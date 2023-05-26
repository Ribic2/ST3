<template>
    <v-card-actions>
        <v-avatar color="brown">
            <span>{{initials}}</span>
        </v-avatar>
        <span class="pl-3">{{ comment.comment }}</span>
    </v-card-actions>
    <v-divider/>
</template>

<script>
export default {
    name: "CommentComponent",
    props: ['comment'],
    computed: {
        initials() {
            return `${this.comment.author.name[0]}${this.comment.author.surname[0]}`
        }
    }
}
</script>

