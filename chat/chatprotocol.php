<?php

declare(strict_types = 1);

namespace Chat;



// Протокол передачи сообщений чата
// Клиент и сервер общаются посредством передачи сообщений друг другу:
// MESSAGE_NAME [MESSAGE_SEPARATOR MESSAGE_DATA] MESSAGE_END
abstract class ChatProtocol {

    // Признак окончания данных в сообщении
    const DATA_END = "|";
    // Разделитель между заголовком сообщения и данными
    const DATA_SEP = "_";
    // Максимальный размер передаваемых сообщений по протоколу
    const MESSAGE_MAX_LENGTH = 100;


    // Шифрование пароля
    protected static function crypt(string $password) {
        return md5($password);
    }

    // Сообщение от клиента или сервера
    protected static function message(string $data) : string {
        return "MESSAGE" . self::DATA_SEP . $data . self::DATA_END;
    }

    // Сообщение о выходе клиента или завершении работы сервера
    protected static function quit() : string {
        return "QUIT" . self::DATA_END;
    }

    // Парсинг сообщения
    protected static function parse(string $message) : array {
        if (strpos($message, self::DATA_SEP)) {
            // Если сообщение содержит данные
            list($message_name, $message_data) = explode(self::DATA_SEP, $message, 2);
            $message_data = substr($message_data, 0, -1);
        } else {
            // Если сообщение не содержит данных
            $message_name = substr($message, 0, -1);;
            $message_data = "";
        }
        return [$message_name, $message_data];
    }

}
