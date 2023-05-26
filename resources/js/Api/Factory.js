import User from './User.js'
import Post from './Post.js'

const repository = {
    User,
    Post
}

export const Factory = {
    get: name => repository[name]
}
