import type { ColumnDef } from '@tanstack/vue-table'
import { h } from 'vue'
import type { Desenvolvedor } from '@/types/Desenvolvedor.ts'
import EditDesenvolvedor from '@/components/desenvolvedor/EditDesenvolvedor.vue'
import DeleteDesenvolvedor from '@/components/desenvolvedor/DeleteDesenvolvedor.vue'

export const columns = (onRefetch: () => void): ColumnDef<Desenvolvedor>[] => [
  {
    accessorKey: 'id',
    header: () => h('div', 'Id'),
  },
  {
    accessorKey: 'nome',
    header: () => h('div', 'Nome'),
  },
  {
    accessorKey: 'sexo',
    header: () => h('div', 'Sexo'),
  },
  {
    accessorKey: 'data_nascimento',
    header: () => h('div', 'Data de nascimento'),
  },
  {
    accessorKey: 'idade',
    header: () => h('div', 'Idade'),
  },
  {
    accessorKey: 'hobby',
    header: () => h('div', 'Hobby'),
  },
  {
    accessorKey: 'nivel.nome',
    header: () => h('div', 'Nível'),
  },
  {
    id: 'actions',
    enableHiding: false,
    cell: ({ row }) => {
      const desenvolvedor = row.original

      return h('div', { class: 'flex items-center gap-2' }, [
        h(EditDesenvolvedor, {
          ...desenvolvedor,
          onRefetch: onRefetch,
        }),
        h(DeleteDesenvolvedor, {
          ...desenvolvedor,
          onRefetch: onRefetch,
        }),
      ])
    },
  },
]
