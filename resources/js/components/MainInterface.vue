<script setup>
import { ref, computed } from 'vue'
import { useToast } from "vue-toastification";
import Paginate from "vuejs-paginate-next";

const toast = useToast()
const isLoadingTitles = ref(false)
const titles = ref(null)
const isLoadingItems = ref(true)
const items = ref(null)

const currentTitlePage = ref(1)
const currentTerm = ref(null)
const totalPages = ref(0)

// Load items via the laravel API using axios
function loadTitles(title, page = null) {
  titles.value = null
  isLoadingTitles.value = true
  // totalPages.value = 0

  const params = {
    term: title,
  }

  if (page) {
    params.page = page
  }

  currentTerm.value = title

  axios.get('/api/titles', { params: params })
    .then(response => {
      titles.value = response.data.titles
      if(totalPages.value != response.data.totalPages) {
        totalPages.value = response.data.total_pages
      }
      isLoadingTitles.value = false
      if (!page) {
        currentTitlePage.value = 1
      }
    }).catch(error => {
      if (error.response.data) {
        toast.error(error.response.data.message)
      } else {
        toast.error('Error loading titles. Please contact support.')
      }
      console.log(error)

      isLoadingTitles.value = false
    })
}

function changePage(page) {
  console.log(page)
  currentTitlePage.value = page
  loadTitles(currentTerm.value, page)
}

/* We'll just simulate a titles fetch with a timeout.
 * In a real app you'd fetch the titles from the server or, even better, have the user type the title in a search box
 */

setTimeout(() => {
  items.value = [
    { id: 1, name: 'Matrix' },
    { id: 2, name: 'Matrix Reloaded' },
    { id: 3, name: 'Matrix Revolutions' },
  ]
  isLoadingItems.value = false
}, 1000)



</script>

<template>
  <div>
    <h2 class="text-center text-3xl font-bold leading-8 tracking-tight text-gray-900 sm:text-4xl mb-4">Omdb Matrix
      Enjoyers Api</h2>
    <p>This project is for hardcore Matrix enjoyers only.</p>
    <p>As such, it will only allow you to search the Omdb for Matrix titles, which are listed on the buttons below.</p>
    <p>If we feel really generous, we'll add a search box, so you can search for other Matrix titles, but be warned that
      searching for anything else will result in a swift IP ban, as we take this stuff <span
        class="text-red-600 font-bold">REALLY</span> seriously.</p>

    <div class="my-4">
      <div class="w-full flex justify-center" role="status" v-if="isLoadingItems">
        <svg aria-hidden="true" class="mr-2 w-8 h-8 text-gray-200 animate-spin fill-blue-600" viewBox="0 0 100 101"
          fill="none" xmlns="http://www.w3.org/2000/svg">
          <path
            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
            fill="currentColor" />
          <path
            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
            fill="currentFill" />
        </svg>
        <span class="sr-only">Loading...</span>
      </div>
      <div v-else class="flex flex-wrap space-x-4">
        <button @click="loadTitles(item.name)" :disabled="isLoadingItems" :key="item.id"
          :class="isLoadingTitles ? 'title-button-disabled' : 'title-button'" v-for="item in items" type="button">
          {{ item.name }}
        </button>
      </div>
    </div>

    <div class="w-full flex justify-center" role="status" v-if="isLoadingTitles">
      <svg aria-hidden="true" class="mr-2 w-8 h-8 text-gray-200 animate-spin fill-blue-600" viewBox="0 0 100 101"
        fill="none" xmlns="http://www.w3.org/2000/svg">
        <path
          d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
          fill="currentColor" />
        <path
          d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
          fill="currentFill" />
      </svg>
      <span class="sr-only">Loading...</span>
    </div>
    <div v-else-if="titles">
      <div class="mt-6 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
        <div v-for="title in titles" :key="title.id" class="group relative">
          <div
            class="min-h-80 aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-md bg-gray-200 group-hover:opacity-75 lg:aspect-none lg:h-80">
            <img :src="title.poster_url" :alt="title.title + ' poster'"
              class="h-full w-full object-cover object-center lg:h-full lg:w-full" />
          </div>
          <div class="mt-4 flex justify-between">
            <div>
              <h3 class="text-sm text-gray-700">
                <a target="_blank" :href="title.imdb_url">
                  <span aria-hidden="true" class="absolute inset-0" />
                  {{ title.title }}
                </a>
              </h3>
            </div>
            <p class="text-sm font-medium text-gray-900">{{ title.year }}</p>
          </div>
        </div>
      </div>
    </div>

    <div class="py-4 flex justify-center w-full" v-if="titles">
      <paginate
        v-model="currentTitlePage"
        :page-count="totalPages"
        :prev-text="'Prev'"
        :next-text="'Next'"
        :click-handler="changePage"
      >
      </paginate>
    </div>
  </div>
</template>
