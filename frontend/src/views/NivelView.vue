<script setup lang="ts">
import DataTable from '@/components/ui/table/DataTable.vue'
import { computed, onMounted, ref, watch } from 'vue'
import type { Nivel } from '@/types/Nivel.ts'
import { columns } from '@/components/niveis/columns'
import { toast } from 'vue-sonner'
import CreateNivel from '@/components/niveis/CreateNivel.vue'
import { usePagination } from '@/composables/usePagination.ts'
import {
  Pagination,
  PaginationContent,
  PaginationItem,
  PaginationPrevious,
  PaginationNext,
} from '@/components/ui/pagination'
import { Input } from '@/components/ui/input'
import { watchDebounced } from '@vueuse/core'

const data = ref<Nivel[]>([])
const tableColumns = columns(fetchData)
const search = ref('')
const loading = ref(false)
const disableSearch = computed(() => !search.value && totalItems.value === 0)
const {
  currentPage,
  perPage,
  totalItems,
  totalPages,
  nextPage,
  prevPage,
  updatePaginationFromResponse,
} = usePagination()

watch([currentPage, perPage], async () => {
  await fetchData()
})

watchDebounced(
  search,
  () => {
    fetchData()
  },
  { debounce: 500, maxWait: 1000 },
)

async function fetchData(): Promise<void> {
  loading.value = true
  const params = {
    page: currentPage.value,
    per_page: perPage.value,
  }

  if (search.value) {
    params.search = search.value
  }

  const queryParams = new URLSearchParams(params).toString()
  const response = await fetch(`http://localhost/api/nivel?${queryParams}`)
  const responseBody = await response.json()
  loading.value = false

  if (!response.ok) {
    toast(responseBody.message)
  }

  updatePaginationFromResponse(responseBody)
  data.value = responseBody.data
}

onMounted(async () => {
  await fetchData()
})
</script>

<template>
  <div class="flex flex-col min-w-full px-5">
    <div class="flex py-5 gap-5">
      <CreateNivel @refetch="fetchData" />
      <Input
        v-model="search"
        :disabled="disableSearch"
        type="text"
        placeholder="Digite para pesquisar"
      />
    </div>
    <DataTable :columns="tableColumns" :data="data" :loading="loading"></DataTable>
    <div class="flex justify-end items-center mt-4">
      <div class="text-sm text-muted-foreground min-w-[60px]">
        {{ data.length }} de {{ totalItems }}
      </div>

      <Pagination :items-per-page="perPage">
        <PaginationContent class="flex gap-14">
          <PaginationItem :value="0">
            <PaginationPrevious :disabled="currentPage <= 1" @click="prevPage" />
          </PaginationItem>
          <PaginationItem :value="0">
            <PaginationNext :disabled="currentPage >= totalPages" @click="nextPage" />
          </PaginationItem>
        </PaginationContent>
      </Pagination>
    </div>
  </div>
</template>

<style scoped></style>
