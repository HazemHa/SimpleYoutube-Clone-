import adminComments from "../components/CURD/Comments.vue";

import adminUsers from "../components/CURD/Users.vue";

import adminPasswordResets from "../components/CURD/PasswordResets.vue";

import adminVideos from "../components/CURD/Videos.vue";

import adminChannels from "../components/CURD/Channels.vue";


export default [{
        path: "/admin/Comments",
        name: "adminComments",
        component: adminComments
    },

    {
        path: "/admin/Users",
        name: "adminUsers",
        component: adminUsers
    },

    {
        path: "/admin/PasswordResets",
        name: "adminPasswordResets",
        component: adminPasswordResets
    },

    {
        path: "/admin/Videos",
        name: "adminVideos",
        component: adminVideos
    },

    {
        path: "/admin/Channels",
        name: "adminChannels",
        component: adminChannels
    },

]
