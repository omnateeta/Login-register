<?php
    session_start();
   if (!isset($_SESSION["user"])){
    header("Location: login.php");
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Welcome to Dashboard</h1>
        <a href="logout.php" class="btn btn-warning">Log out</a>
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Bulletin Board</title>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50 font-['Inter']">
    <div id="app" class="min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-900">Community Bulletin Board</h1>
                    <div class="flex items-center space-x-4">
                        <button @click="openPostModal" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            <i class="bi bi-plus-lg mr-2"></i>New Post
                        </button>
                        <div class="relative">
                            <button @click="showUserMenu = !showUserMenu" class="flex items-center space-x-2">
                                <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center">
                                    <i class="bi bi-person text-gray-600"></i>
                                </div>
                                <span class="text-gray-700">{{currentUser.role}}</span>
                            </button>
                            <div v-if="showUserMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                                <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Sign out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Filters and Search -->
            <div class="mb-8 flex flex-wrap gap-4">
                <div class="flex-1 min-w-[300px]">
                    <div class="relative">
                        <input type="text" v-model="searchQuery" placeholder="Search posts..." 
                            class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>
                <select v-model="selectedCategory" class="border rounded-lg px-4 py-2 bg-white">
                    <option value="">All Categories</option>
                    <option v-for="category in categories" :value="category">{{category}}</option>
                </select>
                <select v-model="dateFilter" class="border rounded-lg px-4 py-2 bg-white">
                    <option value="all">All Time</option>
                    <option value="today">Today</option>
                    <option value="week">This Week</option>
                    <option value="month">This Month</option>
                </select>
            </div>

            <!-- Posts Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div v-for="post in filteredPosts" :key="post.id" 
                    class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <span :class="getCategoryClass(post.category)" class="px-3 py-1 rounded-full text-sm">
                                {{post.category}}
                            </span>
                            <div class="relative">
                                <button @click="openPostMenu(post.id)" class="text-gray-400 hover:text-gray-600">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <div v-if="activePostMenu === post.id" 
                                    class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
                                    <button @click="editPost(post)" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Edit
                                    </button>
                                    <button @click="deletePost(post.id)" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                        Delete
                                    </button>
                                    <button @click="flagPost(post.id)" class="block w-full text-left px-4 py-2 text-sm text-orange-600 hover:bg-gray-100">
                                        Flag
                                    </button>
                                </div>
                            </div>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{post.title}}</h3>
                        <p class="text-gray-600 mb-4">{{post.content}}</p>
                        <div v-if="post.image" class="mb-4">
                            <img :src="post.image" :alt="post.title" class="rounded-lg w-full h-48 object-cover">
                        </div>
                        <div class="flex justify-between items-center text-sm text-gray-500">
                            <span>{{formatDate(post.date)}}</span>
                            <span>By {{post.author}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- New/Edit Post Modal -->
        <div v-if="showPostModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg w-full max-w-2xl mx-4">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-semibold">{{editingPost ? 'Edit Post' : 'New Post'}}</h2>
                        <button @click="closePostModal" class="text-gray-400 hover:text-gray-600">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                    <form @submit.prevent="submitPost" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                            <input type="text" v-model="postForm.title" required
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                            <select v-model="postForm.category" required
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option v-for="category in categories" :value="category">{{category}}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                            <textarea v-model="postForm.content" required rows="4"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Image (optional)</label>
                            <input type="file" @change="handleImageUpload" accept="image/*"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="flex justify-end space-x-4">
                            <button type="button" @click="closePostModal"
                                class="px-4 py-2 text-gray-600 hover:text-gray-800">
                                Cancel
                            </button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                {{editingPost ? 'Update' : 'Post'}}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const { createApp } = Vue

        createApp({
            data() {
                return {
                    showUserMenu: false,
                    showPostModal: false,
                    activePostMenu: null,
                    searchQuery: '',
                    selectedCategory: '',
                    dateFilter: 'all',
                    editingPost: null,
                    postForm: {
                        title: '',
                        category: '',
                        content: '',
                        image: null
                    },
                    currentUser: {
                        id: 'user123',
                        role: 'Admin'
                    },
                    categories: ['Events', 'News', 'Jobs', 'Housing', 'Services'],
                    posts: []
                }
            },
            computed: {
                filteredPosts() {
                    let filtered = this.posts;
                    
                    // Search filter
                    if (this.searchQuery) {
                        const query = this.searchQuery.toLowerCase();
                        filtered = filtered.filter(post => 
                            post.title.toLowerCase().includes(query) || 
                            post.content.toLowerCase().includes(query)
                        );
                    }

                    // Category filter
                    if (this.selectedCategory) {
                        filtered = filtered.filter(post => post.category === this.selectedCategory);
                    }

                    // Date filter
                    if (this.dateFilter !== 'all') {
                        const now = new Date();
                        filtered = filtered.filter(post => {
                            const postDate = new Date(post.date);
                            switch(this.dateFilter) {
                                case 'today':
                                    return postDate.toDateString() === now.toDateString();
                                case 'week':
                                    const weekAgo = new Date(now.getTime() - 7 * 24 * 60 * 60 * 1000);
                                    return postDate >= weekAgo;
                                case 'month':
                                    const monthAgo = new Date(now.getTime() - 30 * 24 * 60 * 60 * 1000);
                                    return postDate >= monthAgo;
                            }
                        });
                    }

                    return filtered;
                }
            },
            methods: {
                async fetchPosts() {
                    try {
                        const response = await fetch('https://r0c8kgwocscg8gsokogwwsw4.zetaverse.one/db', {
                            method: 'POST',
                            headers: {
                                'Authorization': 'Bearer 5oiPsDGQIyYaz8qcyGj438SuZUn2',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                userId: this.currentUser.id,
                                appSlug: 'community-bulletin',
                                action: 'read',
                                table: 'posts'
                            })
                        });
                        const result = await response.json();
                        if (!result.error) {
                            this.posts = result.data.map(item => item.data);
                        }
                    } catch (error) {
                        console.error('Error fetching posts:', error);
                    }
                },
                openPostModal() {
                    this.editingPost = null;
                    this.postForm = {
                        title: '',
                        category: '',
                        content: '',
                        image: null
                    };
                    this.showPostModal = true;
                },
                closePostModal() {
                    this.showPostModal = false;
                    this.editingPost = null;
                },
                openPostMenu(postId) {
                    this.activePostMenu = this.activePostMenu === postId ? null : postId;
                },
                editPost(post) {
                    this.editingPost = post;
                    this.postForm = { ...post };
                    this.showPostModal = true;
                    this.activePostMenu = null;
                },
                async deletePost(postId) {
                    if (confirm('Are you sure you want to delete this post?')) {
                        try {
                            const response = await fetch('https://r0c8kgwocscg8gsokogwwsw4.zetaverse.one/db', {
                                method: 'POST',
                                headers: {
                                    'Authorization': 'Bearer 5oiPsDGQIyYaz8qcyGj438SuZUn2',
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    userId: this.currentUser.id,
                                    appSlug: 'community-bulletin',
                                    action: 'delete',
                                    table: 'posts',
                                    id: postId
                                })
                            });
                            const result = await response.json();
                            if (!result.error) {
                                this.posts = this.posts.filter(post => post.id !== postId);
                            }
                        } catch (error) {
                            console.error('Error deleting post:', error);
                        }
                    }
                    this.activePostMenu = null;
                },
                flagPost(postId) {
                    // Implementation for flagging posts
                    alert('Post has been flagged for review');
                    this.activePostMenu = null;
                },
                async submitPost() {
                    const postData = {
                        ...this.postForm,
                        author: this.currentUser.role,
                        date: new Date().toISOString(),
                        id: this.editingPost ? this.editingPost.id : Date.now().toString()
                    };

                    try {
                        const response = await fetch('https://r0c8kgwocscg8gsokogwwsw4.zetaverse.one/db', {
                            method: 'POST',
                            headers: {
                                'Authorization': 'Bearer 5oiPsDGQIyYaz8qcyGj438SuZUn2',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                userId: this.currentUser.id,
                                appSlug: 'community-bulletin',
                                action: this.editingPost ? 'update' : 'create',
                                table: 'posts',
                                id: postData.id,
                                data: postData
                            })
                        });
                        const result = await response.json();
                        if (!result.error) {
                            if (this.editingPost) {
                                const index = this.posts.findIndex(p => p.id === postData.id);
                                if (index !== -1) {
                                    this.posts[index] = postData;
                                }
                            } else {
                                this.posts.unshift(postData);
                            }
                            this.closePostModal();
                        }
                    } catch (error) {
                        console.error('Error saving post:', error);
                    }
                },
                handleImageUpload(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.postForm.image = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                },
                formatDate(date) {
                    return new Date(date).toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    });
                },
                getCategoryClass(category) {
                    const classes = {
                        'Events': 'bg-green-100 text-green-800',
                        'News': 'bg-blue-100 text-blue-800',
                        'Jobs': 'bg-purple-100 text-purple-800',
                        'Housing': 'bg-yellow-100 text-yellow-800',
                        'Services': 'bg-pink-100 text-pink-800'
                    };
                    return classes[category] || 'bg-gray-100 text-gray-800';
                }
            },
            mounted() {
                this.fetchPosts();
                
                // Simulated WebSocket connection for real-time updates
                setInterval(() => {
                    this.fetchPosts();
                }, 30000); // Refresh every 30 seconds
            }
        }).mount('#app')
    </script>
</body>
</html>
    </div>
</body>
</html>