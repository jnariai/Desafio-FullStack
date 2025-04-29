<script setup lang="ts">
import { Button } from '@/components/ui/button'
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from '@/components/ui/dialog'
import {
  Form,
  FormControl,
  FormDescription,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from '@/components/ui/form'
import { Pen } from 'lucide-vue-next'

import { Input } from '@/components/ui/input'
import { toast } from 'vue-sonner'
import { toTypedSchema } from '@vee-validate/zod'
import { ref } from 'vue'
import * as z from 'zod'
import type { Nivel } from '@/types/Nivel.ts'

const emit = defineEmits(['refetch'])
const props = defineProps<Nivel>()
const initialValues = ref({ nivel: props.nivel })
const dialogOpen = ref(false)
const loading = ref(false)
const formSchema = toTypedSchema(
  z.object({
    nivel: z.string().min(2).max(50),
  }),
)

async function onSubmit(values: { nivel: string }) {
  loading.value = true
  const response = await fetch('http://localhost/api/nivel/' + props.id, {
    method: 'PUT',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(values),
  })
  const responseBody = await response.json()
  loading.value = false

  if (!response.ok) {
    toast.error(responseBody.message)
    return
  }

  toast.success('Nível atualizado com sucesso')
  emit('refetch')
  dialogOpen.value = false
}
</script>

<template>
  <Form
    v-slot="{ handleSubmit }"
    as=""
    keep-values
    :validation-schema="formSchema"
    :initial-values="initialValues"
  >
    <Dialog v-model:open="dialogOpen">
      <DialogTrigger as-child>
        <Button variant="outline" class="text-zinc-950" :loading="loading">
          <Pen />
        </Button>
      </DialogTrigger>
      <DialogContent class="sm:max-w-[425px]">
        <DialogHeader>
          <DialogTitle class="text-zinc-950">Editar nível</DialogTitle>
          <DialogDescription></DialogDescription>
        </DialogHeader>

        <form id="dialogForm" @submit="handleSubmit($event, onSubmit)">
          <FormField v-slot="{ componentField }" name="nivel">
            <FormItem>
              <FormLabel>Nível</FormLabel>
              <FormControl>
                <Input
                  class="text-zinc-950"
                  type="text"
                  placeholder="Senior"
                  v-bind="componentField"
                />
              </FormControl>
              <FormDescription> Descrição do nível </FormDescription>
              <FormMessage />
            </FormItem>
          </FormField>
        </form>

        <DialogFooter>
          <Button type="submit" form="dialogForm"> Atualizar nível </Button>
        </DialogFooter>
      </DialogContent>
    </Dialog>
  </Form>
</template>
<style scoped></style>
