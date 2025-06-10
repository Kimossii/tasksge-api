<?php

namespace App\Enums;

class Messages
{

    const RETRIEVED_SUCCESSFULLY = 'Registos recuperados com sucesso';
    const CREATED_SUCCESSFULLY = 'Registo criado com sucesso';
    const FETCHED_SUCCESSFULLY = 'Registo obtido com sucesso';
    const UPDATED_SUCCESSFULLY = 'Registo atualizado com sucesso';
    const TRASHED_SUCCESSFULLY = 'Registo descartado com sucesso';
    const VALIDATION_FAILED = 'Falha na validação';
    const NO_QUERY_RESULTS = 'Nenhum registo encontrado';
    const NON_NUMERIC_ID = 'O ID fornecido não é numérico';
    const FORBIDDEN = 'Proibido | Direitos insuficientes para aceder a este recurso';
    const UNAUTHORIZED = 'Não autorizado';
    const LOGGED_OUT_SUCCESSFULLY = 'Desligado com sucesso';
    const INTERNAL_SERVER_ERROR_MESSAGE = "Erro do Servidor Interno";
    const UNAUTHORIZED_DOMAIN_OR_IP = "Domínio ou IP não autorizado";
    const LOGIN_SUCCESSFUL = "Login bem-sucedido";
    const RESET_PASSWORD_SUCCESSFUL = "Redefinição de palavra-passe com sucesso";
    const OTP_SUCCESSFUL = "OTP enviado com sucesso para ";
    const OTP_VERIFIED = "OTP verificado com sucesso";
    const INVALID_USER = "Utilizador inválido";
    const RESOURCE_NOT_FOUND = "Recurso não encontrado";
    const METHOD_NOT_ALLOWED_MSG = "Método não permitido para este endpoint.";
    const DB_QUERY_ERROR_MSG = "Erro de consulta à base de dados";
    const NOT_ACCEPTABLE_MSG  = "Formato de resposta não aceitável";
    const TOO_MANY_ATTEMPT = "Muitas solicitações";
    const DUPLICATE_ENTRY_MSG = "Entrada duplicada – O recurso já existe.";
}

