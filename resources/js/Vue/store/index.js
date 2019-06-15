import Vue from "vue";
import Vuex from "vuex";

import CommentsModule from './CommentsModule';

import UsersModule from './UsersModule';

import PasswordResetsModule from './PasswordResetsModule';

import VideosModule from './VideosModule';

import LikesModule from './LikesModule';

import ChannelsModule from './ChannelsModule';
import { reject } from "q";

Vue.use(Vuex);
const store = new Vuex.Store({
    plugins: [],
    modules: {
        comments: CommentsModule,
        likes: LikesModule,
        users: UsersModule,
        passwordresets: PasswordResetsModule,
        videos: VideosModule,
        channels: ChannelsModule,
    },
    actions: {
        subsToggle({commit},data) {
            let btn2 = data.refs[data.key+data.id][data.id].$el;
          return new Promise((resolve,reject)=>{
            if (btn2.innerText == "UNSUBSCRIBE") {
              this
                .dispatch("users/UnsubscribeChannel", { id: data.custom_id })
                .then(res => {
                    if(res.data.data.mutationSubscribeUnSubscribe.channel_id == -1){

                    }
                  let newClass = btn2.getAttribute("class").replace("grey", "red");
                  btn2.setAttribute("class", newClass);
                  btn2.innerText = "Subscribe";
                  return resolve(mutationSubscribeUnSubscribe.channel_id);
                })
                .catch(err => {});
            } else if(btn2.innerText == "SUBSCRIBE"){
                this
                .dispatch("users/subscribeChannel", { id: data.custom_id })
                .then(res => {
                     if(res.data.data.mutationSubscribeUnSubscribe.channel_id == -1){
                        resolve(-1);
                    }
                  let newClass = btn2.getAttribute("class").replace("red", "grey");
                  btn2.setAttribute("class", newClass);
                  btn2.innerText = "UnSubscribe";
                  return resolve(mutationSubscribeUnSubscribe.channel_id);
                })
                .catch(err => {});
            }
          });
        }
    },
    getters: {
        url(state) {
            return "http://127.0.0.1:8000/";
        }
    }
});
export default store;
