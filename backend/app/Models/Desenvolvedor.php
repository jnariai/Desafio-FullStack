<?php

namespace App\Models;

use App\Casts\TitleCaseCast;
use App\Casts\UcFirstCaseCast;
use App\Data\FilterData;
use App\Enums\Sexo;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * @property int $id,
 * @property int $nivel_id,
 * @property string $nome,
 * @property Sexo $sexo,
 * @property CarbonImmutable $data_nascimento,
 * @property string $hobby,
 */
class Desenvolvedor extends Model
{
    use HasFactory;

    protected $table = 'desenvolvedores';

    protected $fillable = [
        'nivel_id',
        'nome',
        'sexo',
        'data_nascimento',
        'hobby',
    ];

    protected function casts(): array
    {
        return [
            'nome' => TitleCaseCast::class,
            'sexo' => Sexo::class,
            'data_nascimento' => 'immutable_date',
            'hobby' => UcFirstCaseCast::class,
        ];
    }

    public function nivel(): BelongsTo
    {
        return $this->belongsTo(Nivel::class);
    }

    public function idade(): int
    {
        return $this->data_nascimento->diffInYears(CarbonImmutable::now());
    }

    public static function index(FilterData $filter): LengthAwarePaginator
    {
        return self::query()
            ->with('nivel')
            ->join('niveis', 'niveis.id', '=', 'desenvolvedores.nivel_id')
            ->select([
                'desenvolvedores.id',
                'desenvolvedores.nome',
                'desenvolvedores.sexo',
                'desenvolvedores.data_nascimento',
                'desenvolvedores.hobby',
                'desenvolvedores.nivel_id',
                'niveis.nivel as nivel',
            ])
            ->when(! empty($filter->search), function (Builder $query) use ($filter) {
                $query->whereAny([
                    'nome',
                    'sexo',
                    'data_nascimento',
                    'hobby',
                    'nivel',
                ], 'like', "{$filter->search}%");
            })
            ->paginate($filter->pagination->per_page);
    }
}
