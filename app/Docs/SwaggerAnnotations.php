<?php

namespace App\Docs;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="API de Gerenciamento de Tarefas",
 *     version="1.0.0",
 *     description="API RESTful para criar, listar, atualizar e deletar tarefas dos usuários"
 * )
 *
 * @OA\Server(
 *     url="http://localhost:8000/api",
 *     description="Servidor Local"
 * )
 *
 * @OA\SecurityScheme(
 *     type="http",
 *     description="Autenticação via token Sanctum",
 *     name="Authorization",
 *     in="header",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     securityScheme="sanctum"
 * )
 */
class SwaggerAnnotations {}
