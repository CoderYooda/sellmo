<?php

namespace Tests\Unit\Models;

use App\Models\Phone;
use PHPUnit\Framework\TestCase;

class PhoneTest extends TestCase
{
    /**
     * @param $rawPhone
     * @param int $expectedPhone
     * @dataProvider getPhonesProvider
     */
    public function testGetSubdivisionFormatted($rawPhone, int $expectedPhone)
    {
        $phone = new Phone(['phone' => $rawPhone]);
        $this->assertEquals($expectedPhone, $phone->phone);
    }

    public function getPhonesProvider(): array
    {
        return [
            [123456789012, 71234567890],
            ['123456789012', 71234567890],
            ['some trash +7(472)999-99-99', 74729999999],
            ['+7(472)999-99-99', 74729999999],
            ['+7(999)999-99-99', 79999999999],
            ['+8(999)999-99-99', 79999999999],
            ['8(999)999-99-99', 79999999999],
            ['8999999-99-99', 79999999999],
            ['8 999 999 99 99', 79999999999],
            ['+7(999)9999999', 79999999999],
            ['+7(999)9-9-9-9-9-9-9', 79999999999],
            ['+7+999+9-9-9-9-9-9-9', 79999999999],
            ['8+999+9-9-9-9-9-9-9', 79999999999],
            [79999999999, 79999999999],
            [89999999999, 79999999999],
        ];
    }
}
