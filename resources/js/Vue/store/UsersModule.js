import axios from "axios"
export default {
    namespaced: true,
    state: {
        isAuth: false,
        currentUser: {
            access_token: undefined,
            id: -1,
        },
    },
    getters: {
        isAuth(state) {
            return state.isAuth;
        },
        getCurrentUser(state) {
            return state.currentUser;
        }
    },
    mutations: {
        setCurrentUser(state, payload) {
            $cookies.set("user", payload);
            state.currentUser = payload;
        },

        setAuth(state, payload) {
            state.isAuth = payload;
        }
    },
    actions: {
        getUsers({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.get(this.getters.url + `graphql?query=query+FetchUsers{Users{id,name,avatar,email}}`)
                    .then((res) => {
                        resolve(res);
                    }).catch((err) => {
                        reject(err);
                    })
            })
        },
        Login({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.post(this.getters.url + `graphql?query=mutation+Login{mutationLogin(email:"${data.email}",password:"${data.password}"){auth,status,user{id,name,email,avatar,access_token,token_type}}}`)
                    .then((res) => {
                        if (res.data.data.mutationLogin.auth) {
                            axios.defaults.headers.common['Authorization'] = "Bearer " + res.data.data.mutationLogin.user.access_token;
                            commit('setCurrentUser', res.data.data.mutationLogin.user);
                            commit('setAuth', true);
                        }
                        resolve(res);
                    }).catch((err) => {
                        reject(err);
                    })
            })
        },
        setTokenForRequest({
            commit
        }, data) {
            return new Promise((resolve, reject) => {

                let user = $cookies.get('user');
                if (user) {
                    let accessToken = $cookies.get("user").access_token;
                    commit("setCurrentUser", user);
                    axios.defaults.headers.common['Authorization'] = "Bearer " + accessToken;
                    commit('setAuth', true);
                    resolve(this.getters['users/isAuth']);
                } else resolve(this.getters['users/isAuth']);
            });
        },
        Logout({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.post(this.getters.url + `graphql?query=mutation+Logout{mutationLogout(auth:false){auth,status,user{id}}}`)
                    .then((res) => {
                        commit('setCurrentUser', res.data.user);
                        $cookies.remove("access_token");
                        commit('setAuth', false);
                        resolve(false);
                    }).catch((err) => {
                        reject(err);
                    })
            })
        },
        singup({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios
                    .post(this.getters.url + `api/singup`, data, {
                        header: {
                            Accept: "application/json",
                            "Content-Type": "multipart/form-data"
                        }
                    })
                    .then(res => {
                        commit('setCurrentUser', res.data.user);
                        commit('setAuth',res.data.success);
                        resolve(res);
                    })
                    .catch(err => {
                        reject(err);
                    });
            });
        },
        updateProfile({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios
                    .post(this.getters.url + `api/profile`, data, {
                        header: {
                            Accept: "application/json",
                            "Content-Type": "multipart/form-data"
                        }
                    })
                    .then(res => {
                        commit('setCurrentUser', res.data.user);
                        commit('setAuth',res.data.success);
                        resolve(res);
                    })
                    .catch(err => {
                        reject(err);
                    });
            });
        },
        subscribeChannel({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                        axios.post(this.getters.url + `graphql?query=mutation+SubscribeUnSubscribe{mutationSubscribeUnSubscribe(flag:true,channel_id:${data.id}){channel_id}}`)
                            .then((res) => {
                                resolve(res);
                            }).catch((err) => {
                                reject(err);
                            })
                    })

                },
                UnsubscribeChannel({
                    commit
                }, data) {
                    return new Promise((resolve, reject) => {
                                axios.post(this.getters.url + `graphql?query=mutation+SubscribeUnSubscribe{mutationSubscribeUnSubscribe(flag:false,channel_id:${data.id}){channel_id}}`)
                                    .then((res) => {
                                        resolve(res);
                                    }).catch((err) => {
                                        reject(err);
                                    })
                            })

                        },
                        getSubsChannel({
                            commit
                        }, data) {

                            return new Promise((resolve, reject) => {
                                axios.get(this.getters.url + `graphql?query=query+FetchUsers{Users(id:${data.id}){SubsChannel{id,name,logo}}}`)
                                    .then((res) => {
                                        resolve(res);
                                    }).catch((err) => {
                                        reject(err);
                                    })
                            })


                        },
                        getSpecificUsers({
                            commit
                        }, data) {
                            return new Promise((resolve, reject) => {
                                axios.get(this.getters.url + `graphql?query=query+FetchUsers{Users(id:${data.id}){id,name,avatar,email,password}}`)
                                    .then((res) => {
                                        resolve(res);
                                    }).catch((err) => {
                                        reject(err);
                                    })
                            })
                        },
                        createUsers({
                            commit
                        }, data) {
                            return new Promise((resolve, reject) => {
                                axios.get(this.getters.url + `graphql?query=mutation+Users{mutationUsers(flag:"create",name: "${data.name}",avatar: "${data.avatar}",email: "${data.email}",password: "${data.password}"){id,name,avatar,email,password}}`)
                                    .then((res) => {
                                        resolve(res);
                                    }).catch((err) => {
                                        reject(err);
                                    })
                            })
                        },
                        deleteUsers({
                            commit
                        }, data) {
                            return new Promise((resolve, reject) => {
                                axios.get(this.getters.url + `graphql?query=mutation+Users{mutationUsers(id:${data.id},flag:"delete"){id}}`)
                                    .then((res) => {
                                        resolve(res);
                                    }).catch((err) => {
                                        reject(err);
                                    })
                            })
                        },
                        updateUsers({
                            commit
                        }, data) {
                            return new Promise((resolve, reject) => {
                                axios.get(this.getters.url + `graphql?query=mutation+Users{mutationUsers(id:${data.id},flag:"update",name: "${data.name}",avatar: "${data.avatar}",email: "${data.email}",password: "${data.password}"){id,name,avatar,email,password}}`)
                                    .then((res) => {
                                        resolve(res);
                                    }).catch((err) => {
                                        reject(err);
                                    })
                            })
                        },
                }
        }
