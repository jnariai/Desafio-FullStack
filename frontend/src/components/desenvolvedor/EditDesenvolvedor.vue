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
import { onMounted, ref, watch } from 'vue'
import * as z from 'zod'
import type { Desenvolvedor } from '@/types/Desenvolvedor.ts'
import type { Nivel } from '@/types/Nivel.ts'
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'

const emit = defineEmits(['refetch'])
const props = defineProps<Desenvolvedor>()
const initialValues = ref({
  nivel_id: props.nivel.id,
  nome: props.nome,
  sexo: props.sexo,
  data_nascimento: convertDateDMYToYMD(props.data_nascimento),
  hobby: props.hobby,
})
const dialogOpen = ref(false)
const loading = ref(false)
const niveis = ref<Nivel[]>([])
const formSchema = toTypedSchema(
  z.object({
    nivel_id: z.number(),
    nome: z.string().min(2).max(255),
    sexo: z.string().min(1).max(1),
    data_nascimento: z.string(),
    hobby: z.string().min(2).max(255),
  }),
)

function convertDateDMYToYMD(dateStr) {
  const [day, month, year] = dateStr.split('/')
  return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
}

async function onSubmit(values: {
  nivel_id: number
  nome: string
  sexo: string
  data_nascimento: string
  hobby: string
}) {
  loading.value = true
  const response = await fetch('http://localhost/api/desenvolvedor/' + props.id, {
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

  toast.success('Desenvolvedor atualizado com sucesso')
  emit('refetch')
  dialogOpen.value = false
}

async function getNiveis() {
  const response = await fetch('http://localhost/api/select/nivel')
  const responseBody = await response.json()

  if (!response.ok) {
    toast.error(responseBody.message)
    return
  }

  niveis.value = responseBody.data
}

watch(dialogOpen, async (isOpen) => {
  if (isOpen) {
    await getNiveis()
  }
})
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
          <DialogTitle class="text-zinc-950">Editar Desenvolvedor</DialogTitle>
          <DialogDescription></DialogDescription>
        </DialogHeader>

        <form id="dialogForm" @submit="handleSubmit($event, onSubmit)">
          <FormField v-slot="{ componentField }" name="nome">
            <FormItem>
              <FormLabel>Nome</FormLabel>
              <FormControl>
                <Input
                  class="text-zinc-950"
                  type="text"
                  placeholder="João da Silva"
                  v-bind="componentField"
                />
              </FormControl>
              <FormDescription></FormDescription>
              <FormMessage />
            </FormItem>
          </FormField>
          <FormField v-slot="{ componentField }" name="nivel_id">
            <FormItem>
              <FormLabel>Nível</FormLabel>

              <Select v-bind="componentField">
                <FormControl>
                  <SelectTrigger>
                    <SelectValue placeholder="Selecione um nível" />
                  </SelectTrigger>
                </FormControl>
                <SelectContent>
                  <SelectGroup>
                    <SelectItem v-for="nivel in niveis" :value="nivel.id" v-bind:key="nivel.id">
                      {{ nivel.nivel }}
                    </SelectItem>
                  </SelectGroup>
                </SelectContent>
              </Select>
              <FormDescription> </FormDescription>
              <FormMessage />
            </FormItem>
          </FormField>
          <FormField v-slot="{ componentField }" name="sexo">
            <FormItem>
              <FormLabel>Sexo</FormLabel>

              <Select v-bind="componentField">
                <FormControl>
                  <SelectTrigger>
                    <SelectValue placeholder="Selecione um gênero" />
                  </SelectTrigger>
                </FormControl>
                <SelectContent>
                  <SelectGroup>
                    <SelectItem value="M"> Masculino </SelectItem>
                    <SelectItem value="F"> Feminino </SelectItem>
                  </SelectGroup>
                </SelectContent>
              </Select>
              <FormDescription> </FormDescription>
              <FormMessage />
            </FormItem>
          </FormField>
          <FormField v-slot="{ componentField }" name="data_nascimento">
            <FormItem>
              <FormLabel>Data de nascimento</FormLabel>
              <FormControl>
                <Input type="date" v-bind="componentField" />
              </FormControl>
              <FormDescription> </FormDescription>
              <FormMessage />
            </FormItem>
          </FormField>
          <FormField v-slot="{ componentField }" name="hobby">
            <FormItem>
              <FormLabel>Hobby</FormLabel>
              <FormControl>
                <Input
                  class="text-zinc-950"
                  type="text"
                  placeholder="Programar"
                  v-bind="componentField"
                />
              </FormControl>
              <FormDescription></FormDescription>
              <FormMessage />
            </FormItem>
          </FormField>
        </form>

        <DialogFooter>
          <Button type="submit" form="dialogForm"> Atualizar desenvolvedor </Button>
        </DialogFooter>
      </DialogContent>
    </Dialog>
  </Form>
</template>
<style scoped></style>
