<?php


namespace App\Helpers;


class RangeConverter
{
    /**
     *  запрет создания экземпляров
     */
    private function __construct() {}
    /**
     * принимает строку в формате '{N1-N2}{delimiter}{N3-N4} ... {Nn-Nn}' и преобразует ее в сортированный массив
     * уникальных значений.
     *
     * передавать нужно валидную строку. использовать для проверки валидатор
     *
     * в проверках вбрасывается эксепшн общего типа без сообщения, т.к. детализация по заданию не требуется
     * все исключения глушатся.
     *
     * @param string $stringValue значения для конвертирования
     * @param string $delimiter разделитель
     * @param ?int $maxValue максимальное значение элемента массива (больше 0)
     *
     * @return int[] | false
     */
    public static function getNumbers(string $stringValue, string $delimiter, ?int $maxValue = null): ?array
    {
        try {
            if ($maxValue && $maxValue < 1){
                throw new \Exception();
            }
            $resultNumbers = [];
            if (empty($stringValue)) {
                return $resultNumbers;
            }
            //получить пары
            $rangePairs = explode($delimiter, $stringValue);

            foreach ($rangePairs as $pair) {
                //разбить на начало и конец
                $pairBorders = explode('-', $pair);
                $start = (int)$pairBorders[0];
                $end   = (int)($pairBorders[1] ?? null);
                if ($end) {
                    //проверка порядка
                    if ($start > $end) {
                        throw new \Exception();
                    }
                    //проверка на макс значение
                    if ($maxValue && $end > $maxValue) {
                        throw new \Exception();
                    }
                    // проитерировать и записать в массив
                    for ($i = $start; $i <= $end; $i++) {
                        $resultNumbers[] = $i;
                    }
                } else {
                    //проверка на макс значение
                    if ($maxValue && $start > $maxValue) {
                        throw new \Exception();
                    }
                    $resultNumbers[] = $start;
                }
            }
            $resultNumbers = array_unique(array_values($resultNumbers));
            sort($resultNumbers);
            return $resultNumbers;
        }
            //любая ошибка ведет к null
        catch (\Exception $e) {
            return null;
        }
    }
}
