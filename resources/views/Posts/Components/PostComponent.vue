<template>
    <div class="relative">
      <div class="bg-white p-4 rounded-lg shadow-md">
        <h3 class="text-lg font-semibold mb-2">{{ post.title }}</h3>
        <p>{{ post.comment }}</p>
      </div>
      <button @click="showModal" class="absolute top-0 right-0 m-2 text-gray-600 hover:text-gray-800">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 13l-7 7-7-7m14-8l-7 7-7-7"></path>
        </svg>
      </button>
      <div v-if="showCommentModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="bg-white p-4 rounded-lg shadow-md">
          <textarea v-model="newComment" class="w-full mt-2 p-2 border rounded" placeholder="Add a comment..."></textarea>
          <button @click="addComment" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded">Add Comment</button>
          <button @click="closeModal" class="mt-2 px-4 py-2 bg-gray-300 text-gray-800 rounded">Cancel</button>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      post: Object,
    },
    data() {
      return {
        showCommentModal: false,
        newComment: '',
      };
    },
    methods: {
      showModal() {
        this.showCommentModal = true;
      },
      closeModal() {
        this.showCommentModal = false;
        this.newComment = ''; // Reset the new comment input
      },
      addComment() {
        // You can handle the comment addition logic here
        console.log('Adding comment:', this.newComment);
  
        // Close the modal after adding the comment
        this.closeModal();
      },
    },
  };
  </script>
  
  <style scoped>
  /* Add your component-specific styles here if needed */
  </style>
  