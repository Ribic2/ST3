import { createStore } from 'vuex'

// Create a new store instance.
const store = createStore({
    state () {
        return {
            friendRequests: [],
            user:{}
        }
    },
    mutations: {
        addFriendRequest (state, data) {
            state.friendRequests = data
        },
        setUser(state, data){
            state.user = data
        }
    },


})

export default store
