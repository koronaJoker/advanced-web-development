
 <form method="post" action="src/handler.php">
    <label for = "Date">Дата</label>
    <input type="datetime-local" id="Date" name="date">
    <label for="Amount">Сумма транзакции</label>
    <input type="text" id = "Amount" name = "amount" placeholder="Сумма транзакции">

    <label>Категория</label>

        <div class="select">
            <input type="hidden" name="category" id="categoryInput">

            <div id = "Category" class="selected">Выберите категорию</div>
            <div class="options">
                <div class="option">Еда</div>
                <div class="option">Транспорт</div>
                <div class="option">Развлечение</div>
                <div class="option">Другое</div>
            </div>
        </div>

    <label for="Description">Описание</label>
    <input type="text" id="Description" name="description" placeholder="Введите описание">
        
    <button type="submit" id="add" style=" margin-top: 40px;">Добавить транзакцию</button>

 </form>