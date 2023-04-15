<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Movie Search</title>
    <!-- Vue.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <style>
        ul.pagination {
            display: flex;
        }

        ul.pagination li {
            list-style: none;
            margin-right: 10px;
            border-radius: 3px;
            background: #cccccc;
            padding: 2px 6px;
            cursor: pointer;
        }

        ul.pagination li.active {
            background: #ffcc00;
        }
    </style>
</head>
<body>
<div id="app">
    <div>
        <input type="text"
               placeholder="search ..."
               v-model="search_query">
        <button @click="searchMovies(1)">search</button>
        <ul>
            <li v-for="movie in movies"
                :key="movie.id"
                v-text="movie.title">
            </li>
        </ul>
        <hr v-if="page_count>0">
        <ul class="pagination">
            <li v-for="i in page_count"
                :class="{ active: i == current_page }"
                @click="searchMovies(i)"
                v-text="i"></li>
        </ul>
    </div>
</div>

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    let app = new Vue({
        el: '#app',
        data: {
            search_query: '',
            movies: [],
            current_page: 1,
            page_count: 0
        },
        methods: {
            searchMovies(current_page = 1) {
                this.current_page = current_page;

                let url = '{{ url('/api/movies') }}';
                axios.get(url, {
                    params: {
                        q: this.search_query,
                        page: this.current_page
                    }
                }).then(response => {
                    console.log(response)
                    this.movies = response.data.data;
                    this.page_count = response.data.metadata.page_count
                    this.current_page = response.data.metadata.current_page
                }).catch(error => {
                    console.log(error);
                });
            }
        }
    });
</script>
</body>
</html>
