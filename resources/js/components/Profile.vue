<template>
    <div class="row">
        <div class="col-sm-8 mx-auto">
            <h2 class="mb-4">Profile Registration</h2>
            <hr />
            <ProfileForm ref="profileForm"></ProfileForm>
            <div class="form-group text-center mt-3">
                <div class="col-sm-6 mx-auto">
                    <button
                        type="button"
                        class="btn btn-success btn-block"
                        @click.prevent="submitForm"
                    >
                        Profile Create
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from "axios";
import ProfileForm from "./ProfileForm";

export default {
    name: "Profile",
    components: {
        ProfileForm,
    },
    methods: {
        async submitForm() {
            try {
                const result = await this.$refs.profileForm.validateForm();

                if (!result) {
                    // validation failed
                    return;
                }

                await axios.post(
                    "/profile/create",
                    this.$refs.profileForm.getData()
                );
                window.location.href = "/profile/edit";
            } catch (err) {
                let errResponse = err.response;

                if (
                    errResponse !== undefined &&
                    errResponse.data !== undefined &&
                    errResponse.data.message !== undefined
                ) {
                    if (errResponse.data.errors !== undefined) {
                        const messages = [];
                        for (var key in errResponse.data.errors) {
                            if (errResponse.data.errors.hasOwnProperty(key)) {
                                messages.push(errResponse.data.errors[key][0]);
                            }
                        }
                        this.$refs.profileForm.setErrorMessage(messages);
                    } else {
                        this.$refs.profileForm.setErrorMessage([
                            errResponse.data.message,
                        ]);
                    }
                } else {
                    this.$refs.profileForm.setErrorMessage([err.message]);
                }
            }
        },
    },
};
</script>
