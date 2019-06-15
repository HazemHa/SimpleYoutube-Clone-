import axios from "axios"
export default {
    namespaced: true,
    state: {},
    getters: {},
    mutations: {},
    actions: {
        getVideos({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.get(this.getters.url + `graphql?query=query+FetchVideos{Videos{id,created_at,title,description,published,url,thumbnail,allow_comments,user_id,views,channel{id,name}}}`)
                    .then((res) => {
                        resolve(res);
                    }).catch((err) => {
                        reject(err);
                    })
            })
        },
        increaseView({
            commit
        }, data){
            return new Promise((resolve, reject) => {
                axios.post(this.getters.url + `api/increaseView`,data)
                    .then((res) => {
                        resolve(res);
                    }).catch((err) => {
                        reject(err);
                    })
            })
        },
        getSpecificVideos({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.get(this.getters.url + `graphql?query=query+FetchVideos{Videos(id:${data.id}){id,likeNum,title,description,isSubscribe,isLike,published,url,thumbnail,allow_comments,views,channel{id,name},comments{user{name,avatar},body}}}`)
                    .then((res) => {
                        resolve(res);
                    }).catch((err) => {
                        reject(err);
                    })
            })
        },
        searchVideoByTitle({
            commit
        }, data){
            return new Promise((resolve, reject) => {
                axios.get(this.getters.url + `graphql?query=query+FetchVideos{Videos(title:"${data.title}",search:true){id,title,description,isSubscribe,isLike,published,url,thumbnail,allow_comments,views,channel{id,name},comments{user{name,avatar},body}}}`)
                    .then((res) => {
                        resolve(res);
                    }).catch((err) => {
                        reject(err);
                    })
            })
        },
        addVideo({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.post(this.getters.url + `api/addVideo`,data,{ header: {
                    Accept: "application/json",
                    "Content-Type": "multipart/form-data"
                }})
                    .then((res) => {
                        resolve(res);
                    }).catch((err) => {
                        reject(err);
                    })
            })
        },
        deleteVideos({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.get(this.getters.url + `graphql?query=mutation+Videos{mutationVideos(id:${data.id},flag:"delete"){id}}`)
                    .then((res) => {
                        resolve(res);
                    }).catch((err) => {
                        reject(err);
                    })
            })
        },
        updateVideos({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.get(this.getters.url + `graphql?query=mutation+Videos{mutationVideos(id:${data.id},flag:"update",title: "${data.title}",description: "${data.description}",published: "${data.published}",url: "${data.url}",thumbnail: "${data.thumbnail}",allow_comments: "${data.allow_comments}",views: "${data.views}",channel_id: "${data.channel_id}",user_id: "${data.user_id}"){id,title,description,published,url,thumbnail,allow_comments,views,channel_id,user_id}}`)
                    .then((res) => {
                        resolve(res);
                    }).catch((err) => {
                        reject(err);
                    })
            })
        },
    }
}
