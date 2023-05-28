import { createStore } from 'vuex'

// Create a new store instance.
const store = createStore({
    state () {
        return {
            friendRequests: [],
            user:{},
            posts: []
        }
    },
    mutations: {
        addFriendRequest (state, data) {
            state.friendRequests = data
        },
        setUser(state, data){
            state.user = data
        },
        setPost(state, data){
            state.posts = data
        }
    },


})

export default store
