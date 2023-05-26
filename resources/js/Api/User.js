const UserEndpoint = axios.create({
    baseURL: `http://homestead.test/api/user`
})


export default {
    async getUser() {
        return await UserEndpoint.post("/")
    },
    async login(data) {
        return await UserEndpoint.post('/login', data);
    },
    async register(data) {
        return await UserEndpoint.post('/register', data);
    },
    async logout() {
        return await UserEndpoint.post('/logout')
    },

    async searchUsers(data) {
        return await UserEndpoint.get('/', data)
    },

    async getSelectedUser(id) {
        return await UserEndpoint.get(`/account/${id}`)
    },

    async addAFriend(data) {
        return await UserEndpoint.post('/add', data)
    },

    async acceptRequest(data) {
        return await UserEndpoint.post('/accept', data)
    },
    async getFriends() {
        return await UserEndpoint.get('/friends')
    }

}
