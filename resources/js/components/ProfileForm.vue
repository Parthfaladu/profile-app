<template>
    <div>
        <div
            v-if="errorMessages && errorMessages.length > 0"
            class="alert alert-danger alert-dismissible mb-5"
        >
            <button type="button" class="close" @click="errorMessages = []">
                &times;
            </button>
            <ul class="mb-0">
                <li v-for="(message, index) in errorMessages" :key="index">
                    {{ message }}
                </li>
            </ul>
        </div>
        <form class="form">
            <div class="form-group">
                <label>First name</label>
                <input
                    type="text"
                    v-model="form.firstName"
                    v-validate="'required'"
                    name="firstname"
                    class="form-control"
                />
                <span
                    v-show="errors.has('firstname')"
                    class="form-control-feedback text-danger"
                    >{{ errors.first("firstname") }}</span
                >
            </div>
            <div class="form-group">
                <label>Last name</label>
                <input
                    v-model="form.lastName"
                    v-validate="'required'"
                    name="lastname"
                    type="text"
                    class="form-control"
                />
                <span
                    v-show="errors.has('lastname')"
                    class="form-control-feedback text-danger"
                    >{{ errors.first("lastname") }}</span
                >
            </div>
            <div class="form-group">
                <label>Email address</label>
                <input
                    v-model="form.email"
                    v-validate="'required|email'"
                    name="email"
                    type="text"
                    class="form-control"
                    :disabled="form && form.userId"
                />
                <span
                    v-show="errors.has('email')"
                    class="form-control-feedback text-danger"
                    >{{ errors.first("email") }}</span
                >
            </div>
            <div v-if="form && !form.userId" class="form-group">
                <label>Password</label>
                <input
                    v-model="form.password"
                    v-validate="'required|min:6'"
                    name="password"
                    type="password"
                    class="form-control"
                />
                <span
                    v-show="errors.has('password')"
                    class="form-control-feedback text-danger"
                    >{{ errors.first("password") }}</span
                >
            </div>
            <div class="d-flex mt-5">
                <h3 class="ml-2 mr-auto">Work experiences</h3>
                <button
                    class="btn btn-info"
                    @click.prevent="addWorkExperience()"
                >
                    Add +
                </button>
            </div>
            <hr />
            <div
                v-for="(workExperience, index) in form.workExperiences"
                :key="index"
            >
                <div class="form-group" :class="{ 'mt-4': index > 0 }">
                    <label class="d-flex"
                        ><span class="mr-auto">({{ index + 1 }}) Comapny</span>
                        <button
                            v-if="index > 0"
                            class="btn btn-danger btn-sm"
                            @click.prevent="removeWorkExperience(index)"
                        >
                            Remove
                        </button></label
                    >
                    <input
                        v-model="workExperience.comapnyName"
                        v-validate="'required'"
                        name="companyname"
                        type="text"
                        class="form-control"
                    />
                    <span
                        v-show="errors.has('companyname')"
                        class="form-control-feedback text-danger"
                        >{{ errors.first("companyname") }}</span
                    >
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <input
                        v-model="workExperience.role"
                        v-validate="'required'"
                        name="role"
                        type="text"
                        class="form-control"
                    />
                    <span
                        v-show="errors.has('role')"
                        class="form-control-feedback text-danger"
                        >{{ errors.first("role") }}</span
                    >
                </div>
                <div class="form-group">
                    <label>Started At</label>
                    <div class="row">
                        <div class="col-sm-6">
                            <select
                                v-model="workExperience.startedAt.month"
                                v-validate="'required'"
                                name="startedAtmonth"
                                class="form-control"
                            >
                                <option :value="null" disabled>
                                    Select month
                                </option>
                                <option
                                    v-for="(month, index) in months"
                                    :key="index"
                                    :value="index + 1"
                                >
                                    {{ month }}
                                </option>
                            </select>
                            <span
                                v-show="errors.has('startedAtmonth')"
                                class="form-control-feedback text-danger"
                                >{{ errors.first("startedAtmonth") }}</span
                            >
                        </div>
                        <div class="col-sm-6">
                            <select
                                v-model="workExperience.startedAt.year"
                                v-validate="'required'"
                                name="startedAtyear"
                                class="form-control"
                            >
                                <option :value="null" disabled>
                                    Select year
                                </option>
                                <option
                                    v-for="year in years"
                                    :value="year"
                                    :key="year"
                                >
                                    {{ year }}
                                </option>
                            </select>
                            <span
                                v-show="errors.has('startedAtyear')"
                                class="form-control-feedback text-danger"
                                >{{ errors.first("startedAtyear") }}</span
                            >
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>End At</label>
                    <div class="row form-group">
                        <div class="col-sm-6">
                            <label>
                                <input
                                    v-model="workExperience.endAtCurrentWorking"
                                    type="checkbox"
                                    class="mr-2"
                                />
                                Current working At
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <select
                                v-model="workExperience.endAt.month"
                                v-validate="{
                                    required:
                                        !workExperience.endAtCurrentWorking,
                                }"
                                name="endAtmonth"
                                class="form-control"
                                :disabled="workExperience.endAtCurrentWorking"
                            >
                                <option :value="null" disabled>
                                    Select month
                                </option>
                                <option
                                    v-for="(month, index) in months"
                                    :key="index"
                                    :value="index + 1"
                                >
                                    {{ month }}
                                </option>
                            </select>
                            <span
                                v-show="errors.has('endAtmonth')"
                                class="form-control-feedback text-danger"
                                >{{ errors.first("endAtmonth") }}</span
                            >
                        </div>
                        <div class="col-sm-6">
                            <select
                                v-model="workExperience.endAt.year"
                                v-validate="{
                                    required:
                                        !workExperience.endAtCurrentWorking,
                                }"
                                name="endAtyear"
                                class="form-control"
                                :disabled="workExperience.endAtCurrentWorking"
                            >
                                <option :value="null" disabled>
                                    Select year
                                </option>
                                <option
                                    v-for="year in years"
                                    :value="year"
                                    :key="year"
                                >
                                    {{ year }}
                                </option>
                            </select>
                            <span
                                v-show="errors.has('endAtyear')"
                                class="form-control-feedback text-danger"
                                >{{ errors.first("endAtyear") }}</span
                            >
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea
                        v-model="workExperience.description"
                        v-validate="'required'"
                        name="workDescription"
                        row="3"
                        class="form-control"
                    ></textarea>
                    <span
                        v-show="errors.has('workDescription')"
                        class="form-control-feedback text-danger"
                        >{{ errors.first("workDescription") }}</span
                    >
                </div>
            </div>
            <div class="d-flex mt-5">
                <h3 class="ml-2 mr-auto">Organization associations</h3>
                <button class="btn btn-info" @click.prevent="addOrganization()">
                    Add +
                </button>
            </div>
            <hr />
            <div
                v-for="(organization, index) in form.organizations"
                :key="index + 100"
            >
                <div class="form-group" :class="{ 'mt-4': index > 0 }">
                    <label class="d-flex"
                        ><span class="mr-auto"
                            >({{ index + 1 }}) Organization</span
                        >
                        <button
                            v-if="index > 0"
                            class="btn btn-danger btn-sm"
                            @click.prevent="removeOrganization(index)"
                        >
                            Remove
                        </button></label
                    >
                    <input
                        v-model="organization.name"
                        v-validate="'required'"
                        name="name"
                        type="text"
                        class="form-control"
                    />
                    <span
                        v-show="errors.has('name')"
                        class="form-control-feedback text-danger"
                        >{{ errors.first("name") }}</span
                    >
                </div>
                <div class="form-group">
                    <label>Associated as</label>
                    <input
                        v-model="organization.associatedAs"
                        v-validate="'required'"
                        name="associatedAs"
                        type="text"
                        class="form-control"
                    />
                    <span
                        v-show="errors.has('associatedAs')"
                        class="form-control-feedback text-danger"
                        >{{ errors.first("associatedAs") }}</span
                    >
                </div>
                <div class="form-group">
                    <label>Started At</label>
                    <div class="row">
                        <div class="col-sm-6">
                            <select
                                v-model="organization.startedAt.month"
                                v-validate="'required'"
                                name="month"
                                class="form-control"
                            >
                                <option :value="null" disabled>
                                    Select month
                                </option>
                                <option
                                    v-for="(month, index) in months"
                                    :key="index + 100"
                                    :value="index + 1"
                                >
                                    {{ month }}
                                </option>
                            </select>
                            <span
                                v-show="errors.has('month')"
                                class="form-control-feedback text-danger"
                                >{{ errors.first("month") }}</span
                            >
                        </div>
                        <div class="col-sm-6">
                            <select
                                v-model="organization.startedAt.year"
                                v-validate="'required'"
                                name="year"
                                class="form-control"
                            >
                                <option :value="null" disabled>
                                    Select year
                                </option>
                                <option
                                    v-for="year in years"
                                    :key="year + 1"
                                    :value="year"
                                >
                                    {{ year }}
                                </option>
                            </select>
                            <span
                                v-show="errors.has('year')"
                                class="form-control-feedback text-danger"
                                >{{ errors.first("year") }}</span
                            >
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>End At</label>
                    <div class="row form-group">
                        <div class="col-sm-6">
                            <label>
                                <input
                                    v-model="organization.endAtCurrentWorking"
                                    type="checkbox"
                                    class="mr-2"
                                />
                                Current working At
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <select
                                v-model="organization.endAt.month"
                                v-validate="{
                                    required: !organization.endAtCurrentWorking,
                                }"
                                name="orgEndAtmonth"
                                class="form-control"
                                :disabled="organization.endAtCurrentWorking"
                            >
                                <option :value="null" disabled>
                                    Select month
                                </option>
                                <option
                                    v-for="(month, index) in months"
                                    :key="index"
                                    :value="index + 1"
                                >
                                    {{ month }}
                                </option>
                            </select>
                            <span
                                v-show="errors.has('orgEndAtmonth')"
                                class="form-control-feedback text-danger"
                                >{{ errors.first("orgEndAtmonth") }}</span
                            >
                        </div>
                        <div class="col-sm-6">
                            <select
                                v-model="organization.endAt.year"
                                v-validate="{
                                    required: !organization.endAtCurrentWorking,
                                }"
                                name="orgEndAtYear"
                                class="form-control"
                                :disabled="organization.endAtCurrentWorking"
                            >
                                <option :value="null" disabled>
                                    Select year
                                </option>
                                <option
                                    v-for="year in years"
                                    :value="year"
                                    :key="year"
                                >
                                    {{ year }}
                                </option>
                            </select>
                            <span
                                v-show="errors.has('orgEndAtYear')"
                                class="form-control-feedback text-danger"
                                >{{ errors.first("orgEndAtYear") }}</span
                            >
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea
                        v-model="organization.description"
                        v-validate="'required'"
                        name="description"
                        row="3"
                        class="form-control"
                    ></textarea>
                    <span
                        v-show="errors.has('description')"
                        class="form-control-feedback text-danger"
                        >{{ errors.first("description") }}</span
                    >
                </div>
            </div>
        </form>
    </div>
</template>
<script>
import moment from "moment";

export default {
    name: "ProfileForm",
    data() {
        return {
            form: {
                firstName: null,
                lastName: null,
                email: null,
                password: null,
                workExperiences: [
                    {
                        comapnyName: null,
                        role: null,
                        startedAt: {
                            month: null,
                            year: null,
                        },
                        endAt: {
                            month: null,
                            year: null,
                        },
                        endAtCurrentWorking: false,
                        description: null,
                    },
                ],
                organizations: [
                    {
                        name: null,
                        associatedAs: null,
                        startedAt: {
                            month: null,
                            year: null,
                        },
                        endAt: {
                            month: null,
                            year: null,
                        },
                        endAtCurrentWorking: false,
                        description: null,
                    },
                ],
            },
            months: [
                "January",
                "February",
                "March",
                "April",
                "May",
                "June",
                "July",
                "August",
                "September",
                "October",
                "November",
                "December",
            ],
            errorMessages: [],
        };
    },
    computed: {
        years() {
            const year = moment().format("YYYY");
            return Array.from(
                { length: year - 1950 },
                (value, index) => 1951 + index
            ).reverse();
        },
    },
    methods: {
        addWorkExperience() {
            this.form.workExperiences.push({
                comapnyName: null,
                role: null,
                startedAt: {
                    month: null,
                    year: null,
                },
                endAt: {
                    month: null,
                    year: null,
                },
                endAtCurrentWorking: false,
                description: null,
            });
        },
        addOrganization() {
            this.form.organizations.push({
                name: null,
                associatedAs: null,
                startedAt: {
                    month: null,
                    year: null,
                },
                endAt: {
                    month: null,
                    year: null,
                },
                endAtCurrentWorking: false,
                description: null,
            });
        },
        removeWorkExperience(index) {
            this.form.workExperiences.splice(index, 1);
        },
        removeOrganization(index) {
            this.form.organizations.splice(index, 1);
        },
        getData() {
            const formData = JSON.parse(JSON.stringify(this.form));

            formData.workExperiences.forEach((experiance) => {
                experiance.startedAt = moment(
                    `01-${experiance.startedAt.month}-${experiance.startedAt.year}`,
                    "DD-M-YYYY"
                ).format("DD-MM-YYYY");
                if (
                    experiance.endAtCurrentWorking === false &&
                    experiance.endAt &&
                    experiance.endAt.month &&
                    experiance.endAt.year
                ) {
                    experiance.endAt = moment(
                        `01-${experiance.endAt.month}-${experiance.endAt.year}`,
                        "DD-M-YYYY"
                    ).format("DD-MM-YYYY");
                } else {
                    experiance.endAt = null;
                }
            });
            formData.organizations.forEach((organization) => {
                organization.startedAt = moment(
                    `01-${organization.startedAt.month}-${organization.startedAt.year}`,
                    "DD-M-YYYY"
                ).format("DD-MM-YYYY");

                if (
                    organization.endAtCurrentWorking === false &&
                    organization.endAt &&
                    organization.endAt.month &&
                    organization.endAt.year
                ) {
                    organization.endAt = moment(
                        `01-${organization.endAt.month}-${organization.endAt.year}`,
                        "DD-M-YYYY"
                    ).format("DD-MM-YYYY");
                } else {
                    organization.endAt = null;
                }
            });
            return formData;
        },
        setData(data) {
            this.form = data;
        },
        async validateForm() {
            this.errorMessages = [];
            const result = await this.$validator.validateAll();
            return result;
        },
        setErrorMessage(messages) {
            this.errorMessages = messages;
        },
    },
};
</script>
