<?php

namespace Tests\Feature\Book;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CreateBookTest extends TestCase
{
    use RefreshDatabase;

    public function test_to_create_book_with_valid_data()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/v1/livros', [
            "titulo " => "exemplo",
            "indices" => [
                [
                    "titulo " => "indice 1",
                    "pagina" => 2,
                    "subindices" => [
                        [
                            "titulo " => "indice 1.1",
                            "pagina" => 3,
                            "subindices" => [
                                [
                                    "titulo " => "indice 1.1.2",
                                    "pagina" => 4,
                                    "subindices" => []
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    "titulo " => "indice 2",
                    "pagina" => 4,
                    "subindices" => []
                ]
            ],
            "document" => "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b2JqCgoxMyAwIG9iago8PC9DcmVhdG9yPEZFRkYwMDU3MDA3MjAwNjkwMDc0MDA2NTAwNzI+Ci9Qcm9kdWNlcjxGRUZGMDA0QzAwNjkwMDYyMDA3MjAwNjUwMDRGMDA2NjAwNjYwMDY5MDA2MzAwNjUwMDIwMDAzNzAwMkUwMDMzPgovQ3JlYXRpb25EYXRlKEQ6MjAyMjEwMTIxNDE4MTQtMDMnMDAnKT4+CmVuZG9iagoKeHJlZgowIDE0CjAwMDAwMDAwMDAgNjU1MzUgZiAKMDAwMDAwNjgxNCAwMDAwMCBuIAowMDAwMDAwMDE5IDAwMDAwIG4gCjAwMDAwMDAyMDUgMDAwMDAgbiAKMDAwMDAwNjk4MyAwMDAwMCBuIAowMDAwMDAwMjI1IDAwMDAwIG4gCjAwMDAwMDU5ODcgMDAwMDAgbiAKMDAwMDAwNjAwOCAwMDAwMCBuIAowMDAwMDA2MTk4IDAwMDAwIG4gCjAwMDAwMDY1MzIgMDAwMDAgbiAKMDAwMDAwNjcyNyAwMDAwMCBuIAowMDAwMDA2NzU5IDAwMDAwIG4gCjAwMDAwMDcxMDggMDAwMDAgbiAKMDAwMDAwNzIwNSAwMDAwMCBuIAp0cmFpbGVyCjw8L1NpemUgMTQvUm9vdCAxMiAwIFIKL0luZm8gMTMgMCBSCi9JRCBbIDw0ODAyQzNFREE5QzVDNzI0QkRDM0NCOEY5MDk1NEI3RD4KPDQ4MDJDM0VEQTlDNUM3MjRCREMzQ0I4RjkwOTU0QjdEPiBdCi9Eb2NDaGVja3N1bSAvNEJCNTA2NDQ0RUM1MTk4QkYzNDI2RkM4NzFBRjM0REQKPj4Kc3RhcnR4cmVmCjczODAKJSVFT0YK",
        ], ['Content-Type: application/json; Accept: application/json']);

        $response->assertStatus(201);
    }

    public function test_to_create_book_with_invalid_data()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/v1/livros', [
            "titulo " => "exemplo",
            "indices" => [
                [
                    "titulos " => "indice 1",
                    "pagiasdna" => 2,
                    "subindicessss" => [
                        [
                            "titulo " => "indice 1.1",
                            "pagina" => 3,
                            "subindices" => [
                                [
                                    "titulo " => "indice 1.1.2",
                                    "pagina" => 4,
                                    "subindices" => []
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    "titulo " => "indice 2",
                    "pagina" => 4,
                    "subindices" => []
                ]
            ],
            "document" => "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b2JqCgoxMyAwIG9iago8PC9DcmVhdG9yPEZFRkYwMDU3MDA3MjAwNjkwMDc0MDA2NTAwNzI+Ci9Qcm9kdWNlcjxGRUZGMDA0QzAwNjkwMDYyMDA3MjAwNjUwMDRGMDA2NjAwNjYwMDY5MDA2MzAwNjUwMDIwMDAzNzAwMkUwMDMzPgovQ3JlYXRpb25EYXRlKEQ6MjAyMjEwMTIxNDE4MTQtMDMnMDAnKT4+CmVuZG9iagoKeHJlZgowIDE0CjAwMDAwMDAwMDAgNjU1MzUgZiAKMDAwMDAwNjgxNCAwMDAwMCBuIAowMDAwMDAwMDE5IDAwMDAwIG4gCjAwMDAwMDAyMDUgMDAwMDAgbiAKMDAwMDAwNjk4MyAwMDAwMCBuIAowMDAwMDAwMjI1IDAwMDAwIG4gCjAwMDAwMDU5ODcgMDAwMDAgbiAKMDAwMDAwNjAwOCAwMDAwMCBuIAowMDAwMDA2MTk4IDAwMDAwIG4gCjAwMDAwMDY1MzIgMDAwMDAgbiAKMDAwMDAwNjcyNyAwMDAwMCBuIAowMDAwMDA2NzU5IDAwMDAwIG4gCjAwMDAwMDcxMDggMDAwMDAgbiAKMDAwMDAwNzIwNSAwMDAwMCBuIAp0cmFpbGVyCjw8L1NpemUgMTQvUm9vdCAxMiAwIFIKL0luZm8gMTMgMCBSCi9JRCBbIDw0ODAyQzNFREE5QzVDNzI0QkRDM0NCOEY5MDk1NEI3RD4KPDQ4MDJDM0VEQTlDNUM3MjRCREMzQ0I4RjkwOTU0QjdEPiBdCi9Eb2NDaGVja3N1bSAvNEJCNTA2NDQ0RUM1MTk4QkYzNDI2RkM4NzFBRjM0REQKPj4Kc3RhcnR4cmVmCjczODAKJSVFT0YK",
        ], ['Content-Type: application/json; Accept: application/json']);

        $response->assertStatus(422);
    }

    public function test_to_create_book_without_logged_user()
    {
        $response = $this->postJson('/api/v1/livros', [
            "titulo " => "exemplo",
            "indices" => [
                [
                    "titulo " => "indice 1",
                    "pagina" => 2,
                    "subindices" => [
                        [
                            "titulo " => "indice 1.1",
                            "pagina" => 3,
                            "subindices" => [
                                [
                                    "titulo " => "indice 1.1.2",
                                    "pagina" => 4,
                                    "subindices" => []
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    "titulo " => "indice 2",
                    "pagina" => 4,
                    "subindices" => []
                ]
            ],
            "document" => "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b2JqCgoxMyAwIG9iago8PC9DcmVhdG9yPEZFRkYwMDU3MDA3MjAwNjkwMDc0MDA2NTAwNzI+Ci9Qcm9kdWNlcjxGRUZGMDA0QzAwNjkwMDYyMDA3MjAwNjUwMDRGMDA2NjAwNjYwMDY5MDA2MzAwNjUwMDIwMDAzNzAwMkUwMDMzPgovQ3JlYXRpb25EYXRlKEQ6MjAyMjEwMTIxNDE4MTQtMDMnMDAnKT4+CmVuZG9iagoKeHJlZgowIDE0CjAwMDAwMDAwMDAgNjU1MzUgZiAKMDAwMDAwNjgxNCAwMDAwMCBuIAowMDAwMDAwMDE5IDAwMDAwIG4gCjAwMDAwMDAyMDUgMDAwMDAgbiAKMDAwMDAwNjk4MyAwMDAwMCBuIAowMDAwMDAwMjI1IDAwMDAwIG4gCjAwMDAwMDU5ODcgMDAwMDAgbiAKMDAwMDAwNjAwOCAwMDAwMCBuIAowMDAwMDA2MTk4IDAwMDAwIG4gCjAwMDAwMDY1MzIgMDAwMDAgbiAKMDAwMDAwNjcyNyAwMDAwMCBuIAowMDAwMDA2NzU5IDAwMDAwIG4gCjAwMDAwMDcxMDggMDAwMDAgbiAKMDAwMDAwNzIwNSAwMDAwMCBuIAp0cmFpbGVyCjw8L1NpemUgMTQvUm9vdCAxMiAwIFIKL0luZm8gMTMgMCBSCi9JRCBbIDw0ODAyQzNFREE5QzVDNzI0QkRDM0NCOEY5MDk1NEI3RD4KPDQ4MDJDM0VEQTlDNUM3MjRCREMzQ0I4RjkwOTU0QjdEPiBdCi9Eb2NDaGVja3N1bSAvNEJCNTA2NDQ0RUM1MTk4QkYzNDI2RkM4NzFBRjM0REQKPj4Kc3RhcnR4cmVmCjczODAKJSVFT0YK",
        ], ['Content-Type: application/json; Accept: application/json']);

        $response->assertUnauthorized();
    }
}
