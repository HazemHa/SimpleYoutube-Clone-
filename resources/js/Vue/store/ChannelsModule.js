import axios from "axios"
export default {
    namespaced: true,
    state: {},
    getters: {},
    mutations: {},
    actions: {
        getMyVideosSubs({
            commit
        }, data){
            return new Promise((resolve, reject) => {
                axios.get(this.getters.url + `graphql?query=query+FetchChannels{Channels(user_id:${data.id}){videos{id,created_at,title,description,url,views,channel{name}}}}`)
                    .then((res) => {
                        resolve(res);
                    }).catch((err) => {
                        reject(err);
                    })
            })
        },
        getMyChannels({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.get(this.getters.url + `graphql?query=query+FetchChannels{Channels(user_id:${data.id}){id,name,logo,cover,about,user_id,videos{id,title,description,url,id,created_at,title,description,url,views,channel{name}}}}`)
                    .then((res) => {
                        resolve(res);
                    }).catch((err) => {
                        reject(err);
                    })
            })
        },
        getChannels({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.get(this.getters.url + `graphql?query=query+FetchChannels{Channels{id,name,logo,cover,about,user_id,user{name,avatar}}}`)
                    .then((res) => {
                        resolve(res);
                    }).catch((err) => {
                        reject(err);
                    })
            })
        },
        getSpecificChannels({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.get(this.getters.url + `graphql?query=query+FetchChannels{Channels(id:${data.id}){id,name,logo,cover,about,user_id,user{name,avatar}}}`)
                    .then((res) => {
                        resolve(res);
                    }).catch((err) => {
                        reject(err);
                    })
            })
        },
        createChannels({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.get(this.getters.url + `graphql?query=mutation+Channels{mutationChannels(flag:"create",id:${data.id},name:"${data.name}",about:"${data.about}"){id,name,about,user_id}}`)
                    .then((res) => {
                        resolve(res);
                    }).catch((err) => {
                        reject(err);
                    })
            })
        },
        deleteChannels({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.get(this.getters.url + `graphql?query=mutation+Channels{mutationChannels(id:${data.id},flag:"delete"){id}}`)
                    .then((res) => {
                        resolve(res);
                    }).catch((err) => {
                        reject(err);
                    })
            })
        },
        updateChannels({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.get(this.getters.url + `graphql?query=mutation+Channels{mutationChannels(id:${data.id},flag:"update",name: "${data.name}",logo: "${data.logo}",cover: "${data.cover}",about: "${data.about}",user_id: "${data.user_id}"){id,name,logo,cover,about,user_id}}`)
                    .then((res) => {
                        resolve(res);
                    }).catch((err) => {
                        reject(err);
                    })
            })
        },
    }
}
