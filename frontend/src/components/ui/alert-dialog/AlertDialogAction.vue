<script setup lang="ts">
import { cn } from '@/lib/utils'
import { buttonVariants } from '@/components/ui/button'
import { AlertDialogAction, type AlertDialogActionProps } from 'reka-ui'
import { computed, type HTMLAttributes } from 'vue'
import { Loader2 } from 'lucide-vue-next'

const props = defineProps<
  AlertDialogActionProps & { class?: HTMLAttributes['class']; loading?: boolean }
>()

const delegatedProps = computed(() => {
  const { class: _, ...delegated } = props

  return delegated
})
</script>

<template>
  <AlertDialogAction
    v-bind="delegatedProps"
    :class="cn(buttonVariants(), props.class)"
    :disabled="props.loading"
  >
    <Loader2 v-if="props.loading" class="w-4 h-4 mr-2 animate-spin" />
    <slot v-else />
  </AlertDialogAction>
</template>
