import axios from "axios"
export default {
    namespaced: true,
    state: {},
    getters: {},
    mutations: {},
    actions: {
        getComments({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.get(this.getters.url + `graphql?query=query+FetchComments{Comments{id,body,approved,video_id,user_id,user{id,name,avatar}}}`)
                    .then((res) => {
                        resolve(res);
                    }).catch((err) => {
                        reject(err);
                    })
            })
        },
        getSpecificComments({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.get(this.getters.url + `graphql?query=query+FetchComments{Comments(id:${data.id}){id,body,video_id,user_id,user{id,name,avatar}}}`)
                    .then((res) => {
                        resolve(res);
                    }).catch((err) => {
                        reject(err);
                    })
            })
        },
        createComments({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.get(this.getters.url + `graphql?query=mutation+Comments{mutationComments(flag:"create",body: "${data.body}",video_id:${data.video_id}){id,body,user{name,avatar}}}`)
                    .then((res) => {
                        console.log(res);
                        resolve(res);
                    }).catch((err) => {
                        reject(err);
                    })
            })
        },
        myChannel({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.get(this.getters.url + `graphql?query=mutation+Comments{mutationComments(id:${data.id},flag:"delete"){id}}`)
                    .then((res) => {
                        resolve(res);
                    }).catch((err) => {
                        reject(err);
                    })
            })
        },
        deleteComments({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.get(this.getters.url + `graphql?query=mutation+Comments{mutationComments(id:${data.id},flag:"delete"){id}}`)
                    .then((res) => {
                        resolve(res);
                    }).catch((err) => {
                        reject(err);
                    })
            })
        },
        updateComments({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.get(this.getters.url + `graphql?query=mutation+Comments{mutationComments(id:${data.id},flag:"update",body: "${data.body}",video_id: "${data.video_id}",user_id: "${data.user_id}"){id,body,video_id,user_id}}`)
                    .then((res) => {
                        resolve(res);
                    }).catch((err) => {
                        reject(err);
                    })
            })
        },
    }
}
