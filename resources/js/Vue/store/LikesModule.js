import axios from "axios"
export default {
namespaced: true,
    state: {},
    getters: {},
    mutations: {},
    actions: {
getLikes({commit},data) {
            return new Promise((resolve, reject) => {
                axios.get(this.getters.url +`graphql?query=query+FetchLikes{Likes{id,video_id,user_id,user{name,avatar},video{id,title,description,url,views,channel{name,logo}}}}`)
                    .then((res) => {
                        resolve(res);
                    }).catch((err) => {
                        reject(err);
                    })
            })},
createLikes({commit},data) {
            return new Promise((resolve, reject) => {
                axios.get(this.getters.url +`graphql?query=mutation+Likes{mutationLikes(flag:"create",video_id:${data.video_id}){id,video_id,user_id}}`)
                    .then((res) => {
                        resolve(res);
                    }).catch((err) => {
                        reject(err);
                    })
            })},
deleteLikes({commit},data) {
            return new Promise((resolve, reject) => {
                axios.get(this.getters.url +`graphql?query=mutation+Likes{mutationLikes(id:${data.video_id},flag:"delete"){id}}`)
                    .then((res) => {
                        resolve(res);
                    }).catch((err) => {
                        reject(err);
                    })
            })}
}}
