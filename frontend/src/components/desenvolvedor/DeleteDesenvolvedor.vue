<script setup lang="ts">
import {
  AlertDialog,
  AlertDialogAction,
  AlertDialogCancel,
  AlertDialogContent,
  AlertDialogDescription,
  AlertDialogFooter,
  AlertDialogHeader,
  AlertDialogTitle,
  AlertDialogTrigger,
} from '@/components/ui/alert-dialog'
import { Button } from '@/components/ui/button'
import { Trash } from 'lucide-vue-next'
import { toast } from 'vue-sonner'
import { ref } from 'vue'
import type { Desenvolvedor } from '@/types/Desenvolvedor.ts'
const emit = defineEmits(['refetch'])
const props = defineProps<Desenvolvedor>()
const loading = ref(false)

async function deleteDesenvolvedor() {
  loading.value = true
  const response = await fetch('http://localhost/api/desenvolvedor/' + props.id, {
    method: 'DELETE',
    headers: {
      'Content-Type': 'application/json',
    },
  })
  loading.value = false

  if (!response.ok) {
    const responseBody = await response.json()
    toast.error(responseBody.message)
    return
  }

  toast.success('Nível apagado com sucesso')
  emit('refetch')
}
</script>

<template>
  <AlertDialog>
    <AlertDialogTrigger as-child>
      <Button variant="outline">
        <Trash />
      </Button>
    </AlertDialogTrigger>
    <AlertDialogContent>
      <AlertDialogHeader>
        <AlertDialogTitle
          >Tem certeza que deseja apagar o desenvolvedor {{ props.nome }}?</AlertDialogTitle
        >
        <AlertDialogDescription>
          Essa ação não pode ser desfeita. Isso apagará permanentemente o desenvolvedor.
        </AlertDialogDescription>
      </AlertDialogHeader>
      <AlertDialogFooter>
        <AlertDialogCancel>Cancelar</AlertDialogCancel>
        <AlertDialogAction @click="deleteDesenvolvedor">Apagar</AlertDialogAction>
      </AlertDialogFooter>
    </AlertDialogContent>
  </AlertDialog>
</template>
<style scoped></style>
