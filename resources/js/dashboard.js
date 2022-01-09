import Vue from "vue";
import VeeValidate from "vee-validate";
import ProfileEdit from "./components/ProfileEdit.vue";

Vue.use(VeeValidate, { fieldsBagName: "formFields" });

var app = new Vue({
    el: "#dashboard",
    components: {
        profileedit: ProfileEdit,
    },
});
