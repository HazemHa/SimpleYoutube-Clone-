import BrowserChannels from "../components/pages/BrowserChannels.vue";

import subscriptions from "../components/pages/subscriptions.vue";

import trending from "../components/pages/trending.vue";

import subscriptionDetails from "../components/pages/subscriptionDetails.vue";
import specificVideo from "../components/pages/specificVideo.vue";
import home from "../components/pages/home.vue"

import login from "../components/pages/User/singin.vue";
import register from "../components/pages/User/singup.vue";
import profile from '../components/pages/User/profile.vue';
import addVideo from '../components/pages/addVideo.vue';
import manageChannel from '../components/pages/manageChannel.vue';
import searchResult from '../components/pages/searchResult.vue';
export default [
    {
        path: "/",
        name: "home",
        component: home
    },
    {
        path: "/login",
        name: "login",
        component: login
    },
    {
        path: "/searchResult/:keyword",
        name: "searchResult",
        component: searchResult
    },
    {
        path: "/register",
        name: "register",
        component: register
    }
    ,
    {
        path: "/manageChannel",
        name: "manageChannel",
        component: manageChannel
    }
    ,
    {
        path: "/addVideo",
        name: "addVideo",
        component: addVideo
    },
    {
        path: "/profile",
        name: "profile",
        component: profile
    },
    {
        path: "/BrowserChannels",
        name: "BrowserChannels",
        component: BrowserChannels
    },
    {
        path: "/video/:id",
        name: "specificVideo",
        component: specificVideo
    },

    {
        path: "/subscriptions",
        name: "subscriptions",
        component: subscriptions
    },

    {
        path: "/trending",
        name: "trending",
        component: trending
    },

    {
        path: "/subscription/:id",
        name: "subscriptionDetails",
        component: subscriptionDetails
    },


]
