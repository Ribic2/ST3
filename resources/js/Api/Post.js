const PostEndpoint = axios.create({
    baseURL: `http://homestead.test/api/post`
})


export default {
    async createPost(data) {
        return await PostEndpoint.post("/", data)
    },
    async getPost() {
        return await PostEndpoint.get("/")
    },
    async likePost(data) {
        return await PostEndpoint.post('/like', data)
    },
    async addNewComment(data) {
        return await PostEndpoint.post('/comment', data)
    },
    async deletePost(data) {
        return await PostEndpoint.post('/delete', data)
    },
    async editPost(data){
        return await PostEndpoint.post('/update', data)
    }
}
