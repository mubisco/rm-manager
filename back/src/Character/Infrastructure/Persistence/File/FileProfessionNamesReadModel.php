<?php

declare(strict_types=1);

namespace App\Character\Infrastructure\Persistence\File;

use App\Character\Domain\Profession\ProfessionCode;
use App\Character\Domain\Profession\ProfessionLanguage;
use App\Character\Domain\Profession\ProfessionNamesReadException;
use App\Character\Domain\Profession\ProfessionNamesReadModel;
use App\Character\Domain\Profession\ProfessionNotFoundException;
use App\Character\Domain\Profession\ProfessionReadModel;
use InvalidArgumentException;
use JsonException;

final class FileProfessionNamesReadModel implements ProfessionNamesReadModel, ProfessionReadModel
{
    public function __construct(private readonly string $jsonDataFilePath)
    {
        if (!file_exists($jsonDataFilePath)) {
            throw new InvalidArgumentException("{$jsonDataFilePath} path does not exists!!!");
        }
    }
    public function ofLanguage(ProfessionLanguage $lang): array
    {
        try {
            $parsedData = $this->parseFileContent();
            $response = $this->parseItems($parsedData, $lang);
            usort($response, function (array $a, array $b) {
                return strnatcmp((string) $a['name'], (string) $b['name']);
            });
            return $response;
        } catch (JsonException $e) {
            throw new ProfessionNamesReadException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @return array<int, mixed>
     * @psalm-suppress MixedInferredReturnType
     */
    private function parseFileContent(): array
    {
        $content = file_get_contents($this->jsonDataFilePath);
        if ($content === false) {
            $content = '';
        }
        /** @psalm-suppress MixedReturnStatement */
        return json_decode($content, true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * @return array<int, array<string, string>>
     * @param array<int,mixed> $parsedData
     */
    private function parseItems(array $parsedData, ProfessionLanguage $lang): array
    {
        $response = [];
        /** @psalm-suppress MixedAssignment */
        foreach ($parsedData as $item) {
            /** @psalm-suppress MixedArgument */
            $response[] = $this->parseSingleItem($item, $lang);
        }
        return $response;
    }

    /**
     * @param array<string,mixed> $item
     * @return array<string, string>
     */
    private function parseSingleItem(array $item, ProfessionLanguage $lang): array
    {
        /** @psalm-suppress MixedArrayAccess */
        return [
            'code' => (string) $item['code'],
            'name' => (string) $item['name'][$lang->value()]
        ];
    }

    public function ofCode(ProfessionLanguage $lang, ProfessionCode $code): array
    {
        $simpleProfession = $this->filterByCode($code);
        return $this->filterTranslations($simpleProfession, $lang);
    }
    /**
     * @return array<string,mixed>
     */
    private function filterByCode(ProfessionCode $code): array
    {
        $data = $this->parseFileContent();
        foreach ($data as $item) {
            if ($item['code'] == $code->value) {
                return $item;
            }
        }
        throw new ProfessionNotFoundException("{$code->value} not found inside data");
    }
    /**
     * @param array<string,mixed> $dataItem
     * @return array<string,mixed>
     */
    private function filterTranslations(array $dataItem, ProfessionLanguage $lang): array
    {
        $dataItem['name'] = $dataItem['name'][$lang->value()];
        $dataItem['description'] = $dataItem['description'][$lang->value()];
        $dataItem['professionalAbilities'] = $dataItem['professionalAbilities'][$lang->value()];
        $dataItem['notes'] = $dataItem['notes'][$lang->value()];
        return $dataItem;
    }
}
