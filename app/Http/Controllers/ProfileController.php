<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\Models\{User, OrganizationAssociation, WorkExperience};
use App\Http\Requests\{ProfileCreateRequest, ProfileLoginRequest};
use App\Http\Resources\UserResource;
use Session;

class ProfileController extends Controller
{
    public function create(ProfileCreateRequest $request)
    {
        $user = new User;
        $user->first_name = $request->get("firstName");
        $user->last_name  = $request->get("lastName");
        $user->email      = $request->get("email");
        $user->password   = bcrypt($request->get("password"));
        $user->save();

        foreach($request->get("workExperiences") as $reqWorkExperience)
        {
            $this->saveWorkExperiance(new WorkExperience, $reqWorkExperience, $user->id);
        }

        foreach($request->get("organizations") as $organization)
        {
            $this->saveOrganization(new OrganizationAssociation, $organization, $user->id);
        }
        //login to dashboard created profile user
        Auth::loginUsingId($user->id);
        return response()->json(["status" => "success"]);
    }

    public function updateProfile(Request $request)
    {
        $user = User::findOrFail(Auth::id());
        $user->first_name = $request->get("firstName");
        $user->last_name  = $request->get("lastName");
        $user->save();

        // removed records delete from database
        $this->removeDeletedRecords(new WorkExperience, $request->get("workExperiences"));
        $this->removeDeletedRecords(new OrganizationAssociation, $request->get("organizations"));

        foreach($request->get("workExperiences") as $reqWorkExperience)
        {
            if(isset($reqWorkExperience['id'])) {
                $workExperience = WorkExperience::findOrFail($reqWorkExperience['id']);
            }
            else {
                $workExperience = new WorkExperience;
            }
            $this->saveWorkExperiance($workExperience, $reqWorkExperience, Auth::id());
        }

        foreach($request->get("organizations") as $organization)
        {
            if(isset($organization['id'])) {
                $organizationAssociation = OrganizationAssociation::findOrFail($organization['id']);
            }
            else {
                $organizationAssociation = new OrganizationAssociation;
            }
            $this->saveOrganization($organizationAssociation, $organization, Auth::id());
        }
        return response()->json(["status" => "success"]);
    }

    private function saveWorkExperiance($workExperience, $reqWorkExperience, $userId)
    {
        $workExperience->company_name        = $reqWorkExperience["comapnyName"];
        $workExperience->role                = $reqWorkExperience["role"];
        $workExperience->start_at            = Carbon::parse($reqWorkExperience["startedAt"]);
        $workExperience->end_at              = $reqWorkExperience["endAtCurrentWorking"] === false ? Carbon::parse($reqWorkExperience["endAt"]) : null;
        $workExperience->end_at_current_work = $reqWorkExperience["endAtCurrentWorking"];
        $workExperience->description         = $reqWorkExperience["description"];
        $workExperience->user_id             = $userId;
        $workExperience->save();
    }

    private function saveOrganization($organizationAssociation, $organization, $userId)
    {
        $organizationAssociation->name                = $organization["name"];
        $organizationAssociation->assocciated_as      = $organization["associatedAs"];
        $organizationAssociation->start_at            = Carbon::parse($organization["startedAt"]);
        $organizationAssociation->end_at              = $organization["endAtCurrentWorking"] === false ? Carbon::parse($organization["endAt"]) : null;
        $organizationAssociation->end_at_current_work = $organization["endAtCurrentWorking"];
        $organizationAssociation->description         = $organization["description"];
        $organizationAssociation->user_id             = $userId;
        $organizationAssociation->save();
    }

    private function removeDeletedRecords($model, $requestData)
    {
        $requestIds = array_column($requestData, 'id');
        $dbIds = $model->where("user_id", Auth::id())->pluck('id')->toArray();

        // removed records id array
        $deletedIds = array_diff($dbIds, $requestIds);

        $model->whereIn("id", $deletedIds)->delete();
    }

    public function login(ProfileLoginRequest $request)
    {
        $user = User::where("email", $request->get("email"))->first();

        if (Auth::attempt($request->only(['email','password']))) {
            return redirect()->to("/profile/edit");
        }
        Session::flash("message", "Invalid credentials!");
        return redirect()->back();
    }

    public function profileDetails(Request $request)
    {
        $user = User::with('workexperiances', 'organizationassociation')->findOrFail(Auth::id());
        return response()->json(new UserResource($user));
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->to('/');
    }
}
