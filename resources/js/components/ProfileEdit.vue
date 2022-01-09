<template>
    <div class="row">
        <div class="col-sm-8 mx-auto">
            <h2 class="mb-4">Profile Edit</h2>
            <hr />
            <div
                v-if="messages && messages.length > 0"
                class="alert alert-success alert-dismissible mb-5"
            >
                <button type="button" class="close" @click="messages = []">
                    &times;
                </button>
                <ul class="mb-0">
                    <li v-for="(message, index) in messages" :key="index">
                        {{ message }}
                    </li>
                </ul>
            </div>
            <ProfileForm ref="profileForm"></ProfileForm>
            <div class="form-group text-center mt-3">
                <div class="col-sm-6 mx-auto">
                    <button
                        type="button"
                        class="btn btn-success btn-block"
                        @click.prevent="submitForm"
                    >
                        Profile Update
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
    name: "ProfileEdit",
    components: {
        ProfileForm,
    },
    data() {
        return {
            messages: [],
        };
    },
    async mounted() {
        try {
            const res = await axios.get("/profile");
            this.$refs.profileForm.setData(res.data);
        } catch (err) {
            console.log(err);
        }
    },
    methods: {
        async submitForm() {
            try {
                this.messages = [];
                const result = await this.$refs.profileForm.validateForm();

                if (!result) {
                    // validation failed
                    return;
                }

                const reqData = this.$refs.profileForm.getData();

                await axios.put(`/profile`, reqData);
                this.messages = ["Successfully profile updated."];
            } catch (err) {
                console.log(err);
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
