<?php

namespace Tests\Unit\App\Http\Requests;

use App\Http\Requests\BudgetStoreRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Factory;
use Tests\TestCase;

class BudgetStoreRequestTest extends TestCase
{
    private Factory $validator;
    private FormRequest $formRequest;

    protected function setUp(): void
    {
        parent::setUp();

        $this->validator = $this->app->get('validator');
        $this->formRequest = new BudgetStoreRequest;
    }

    /**
     * @test
     * @dataProvider validationProvider
     * @param bool $shouldPass
     * @param array $mockedRequestData
     * @param array $expectedFails
     */
    public function testThatValidationResultsAsExpected(
        bool $shouldPass,
        array $mockedRequestData,
        array $expectedFails = []
    ) {
        $validator = $this->validator->make($mockedRequestData, $this->formRequest->rules());

        $this->assertEquals(
            $shouldPass,
            $validator->passes(),
            "With data: {$this->dataName()} [{$validator->errors()->toJson()}]"
        );

        if (!$shouldPass && count($expectedFails)) {
            foreach ($expectedFails as $value) {
                $this->assertArrayHasKey(
                    $value['type'],
                    $validator->failed()[$value['name']] ?? [],
                    "Invalid validation exception expected, type: {$value['type']} name: {$value['name']}"
                );
            }

            $this->assertSameSize(
                $expectedFails,
                $validator->failed(),
                "Not equals validation error number " . $validator->errors()->toJson()
            );
        }
    }

    public function validationProvider(): array
    {
        return [
            'request_should_fail_when_no_netAmount_is_provided' => [
                'passed' => false,
                'data' => [
                    [
                        'vat' => 21,
                        'vatAmount' => 33.52
                    ]
                ],
                'expected_fails' => [
                    ['type' => 'Required', 'name' => '0.netAmount']
                ]
            ],
            'request_should_fail_when_netAmount_negative' => [
                'passed' => false,
                'data' => [
                    [
                        'netAmount' => -1,
                        'vat' => 21,
                        'vatAmount' => 33.52
                    ]
                ],
                'expected_fails' => [
                    ['type' => 'Min', 'name' => '0.netAmount']
                ]
            ],
            'request_should_fail_when_netAmount_not_numeric' => [
                'passed' => false,
                'data' => [
                    [
                        'netAmount' => 'dummy',
                        'vat' => 21,
                        'vatAmount' => 33.52
                    ]
                ],
                'expected_fails' => [
                    ['type' => 'Numeric', 'name' => '0.netAmount']
                ]
            ],
            'request_should_fail_when_no_vat_is_provided' => [
                'passed' => false,
                'data' => [
                    [
                        'netAmount' => 159.6,
                        'vatAmount' => 33.52
                    ]
                ],
                'expected_fails' => [
                    ['type' => 'Required', 'name' => '0.vat']
                ]
            ],
            'request_should_fail_when_vat_negative' => [
                'passed' => false,
                'data' => [
                    [
                        'netAmount' => 159.6,
                        'vat' => -1,
                        'vatAmount' => 33.52
                    ]
                ],
                'expected_fails' => [
                    ['type' => 'Min', 'name' => '0.vat']
                ]
            ],
            'request_should_fail_when_vat_not_numeric' => [
                'passed' => false,
                'data' => [
                    [
                        'netAmount' => 159.6,
                        'vat' => 'dummy',
                        'vatAmount' => 33.52
                    ]
                ],
                'expected_fails' => [
                    ['type' => 'Numeric', 'name' => '0.vat']
                ]
            ],
            'request_should_fail_when_no_vatAmount_is_provided' => [
                'passed' => false,
                'data' => [
                    [
                        'netAmount' => 159.6,
                        'vat' => 21
                    ]
                ],
                'expected_fails' => [
                    ['type' => 'Required', 'name' => '0.vatAmount']
                ]
            ],
            'request_should_fail_when_vatAmount_negative' => [
                'passed' => false,
                'data' => [
                    [
                        'netAmount' => 159.6,
                        'vat' => 21,
                        'vatAmount' => -33.52
                    ]
                ],
                'expected_fails' => [
                    ['type' => 'Min', 'name' => '0.vatAmount']
                ]
            ],
            'request_should_fail_when_vatAmount_not_numeric' => [
                'passed' => false,
                'data' => [
                    [
                        'netAmount' => 159.6,
                        'vat' => 21,
                        'vatAmount' => 'dummy'
                    ]
                ],
                'expected_fails' => [
                    ['type' => 'Numeric', 'name' => '0.vatAmount']
                ]
            ],
            'should_pass_when_valid_data_is_provided' => [
                'passed' => true,
                'data' => [
                    [
                        'netAmount' => 159.6,
                        'vat' => 21,
                        'vatAmount' => 33.52
                    ],
                    [
                        'netAmount' => 247.11,
                        'vat' => 21,
                        'vatAmount' => 51.89
                    ],
                ]
            ],
        ];
    }
}
