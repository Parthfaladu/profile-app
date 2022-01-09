import Vue from "vue";
import VeeValidate from "vee-validate";
import Profile from "./components/Profile.vue";
import ProfileEdit from "./components/ProfileEdit.vue";

Vue.use(VeeValidate, { fieldsBagName: "formFields" });

var app = new Vue({
    el: "#app",
    components: {
        Profile,
        ProfileEdit,
    },
});

// var app = new Vue({
//     el: "#dashboard",
//     components: {
//         ProfileEdit,
//     },
// });
