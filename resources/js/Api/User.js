const UserEndpoint = axios.create({
    baseURL: `${process.env.APP_URL}/api/user`
})


export default {
    async getUser() {
        return await UserEndpoint.post("/user")
    },
    async login(data) {
        await UserEndpoint.post('/user/login', data).then((res) => {
            axios.defaults.headers.common['Authorization'] = `Bearer ${res.data.token}`;
        })
    },
    async register(data) {
        await UserEndpoint.post('/user/register', data).then((res) => {
            axios.defaults.headers.common['Authorization'] = `Bearer ${res.data.token}`;
        })
    },
    async logout() {
        return await UserEndpoint.post('/user/logout')
    }
}
