# Check_List

// (POST)   http://localhost:8000/api/v1/register - Регистрация API
// (POST)   http://localhost:8000/oauth/token - Вход в API
// (GET)    http://localhost:8000/api/v1/tasks - Список заданий
// (POST)   http://localhost:8000/api/v1/tasks - Добавить задание
// (GET)    http://localhost:8000/api/v1/tasks/{id} - Показать задание
// (PUT)    http://localhost:8000/api/v1/tasks/{id} - Редактировать задание
// (DELETE) http://localhost:8000/api/v1/tasks/{id} - Удалить задание

Заголовки API
'headers' => [
    'Accept' => 'application/json',
    'Authorization' => 'Bearer '.$accessToken,

Админка через установку "1" поля is_admin в таблице users 
