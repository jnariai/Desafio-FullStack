import type { ColumnDef } from '@tanstack/vue-table'
import type { Nivel } from '@/types/Nivel.ts'
import { h } from 'vue'
import EditNivel from '@/components/niveis/EditNivel.vue'
import DeleteNivel from '@/components/niveis/DeleteNivel.vue'

export const columns = (onRefetch: () => void): ColumnDef<Nivel>[] => [
  {
    accessorKey: 'id',
    header: () => h('div', 'Id'),
  },
  {
    accessorKey: 'nivel',
    header: () => h('div', 'Nível'),
  },
  {
    accessorKey: 'desenvolvedores',
    header: () => h('div', 'Quantidade de desenvolvedores'),
  },
  {
    id: 'edit',
    enableHiding: false,
    cell: ({ row }) => {
      const nivel = row.original

      return h('div', { class: 'flex items-center gap-2' }, [
        h(EditNivel, {
          ...nivel,
          onRefetch: onRefetch,
        }),
        h(DeleteNivel, {
          ...nivel,
          onRefetch: onRefetch,
        }),
      ])
    },
  },
]
