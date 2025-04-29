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
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'
import {
  Form,
  FormControl,
  FormDescription,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from '@/components/ui/form'

import { Input } from '@/components/ui/input'
import { toast } from 'vue-sonner'
import { toTypedSchema } from '@vee-validate/zod'
import { onMounted, ref, watch } from 'vue'
import * as z from 'zod'
import type { Nivel } from '@/types/Nivel.ts'

const dialogOpen = ref(false)
const loading = ref(false)
const emit = defineEmits(['refetch'])
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

async function onSubmit(values: { nivel: string }) {
  loading.value = true
  const response = await fetch('http://localhost/api/desenvolvedor', {
    method: 'POST',
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

  toast.success('Desenvolvedor criado com sucesso')
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
  <Form v-slot="{ handleSubmit }" as="" :validation-schema="formSchema">
    <Dialog v-model:open="dialogOpen">
      <DialogTrigger as-child>
        <Button variant="outline" class="text-zinc-950" :loading="loading">
          Adicionar desenvolvedor
        </Button>
      </DialogTrigger>
      <DialogContent class="sm:max-w-[425px]">
        <DialogHeader>
          <DialogTitle class="text-zinc-950">Adicionar desenvolvedor</DialogTitle>
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
          <Button type="submit" form="dialogForm"> Adicionar um desenvolvedor </Button>
        </DialogFooter>
      </DialogContent>
    </Dialog>
  </Form>
</template>

<style scoped></style>
