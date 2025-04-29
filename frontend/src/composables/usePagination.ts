import { ref, computed, watch } from 'vue'

export function usePagination(
  options = {
    initialPage: 1,
    initialPerPage: 10,
  },
) {
  const { initialPage = 1, initialPerPage = 10 } = options

  const currentPage = ref(initialPage)
  const perPage = ref(initialPerPage)
  const totalItems = ref(0)
  const totalPages = ref(0)

  const pageParams = computed(() => ({
    page: currentPage.value,
    per_page: perPage.value,
  }))

  function setPage(page: number) {
    currentPage.value = page
  }

  function nextPage() {
    if (currentPage.value < totalPages.value) {
      currentPage.value++
    }
  }

  function prevPage() {
    if (currentPage.value > 1) {
      currentPage.value--
    }
  }

  function updatePaginationFromResponse(response: any) {
    if (response.meta) {
      totalItems.value = response.meta.total
      currentPage.value = response.meta.current_page
      totalPages.value = response.meta.last_page
      perPage.value = response.meta.per_page
    }
  }

  return {
    currentPage,
    perPage,
    totalItems,
    totalPages,
    pageParams,
    setPage,
    nextPage,
    prevPage,
    updatePaginationFromResponse,
  }
}
