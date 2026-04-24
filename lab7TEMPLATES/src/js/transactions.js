import { showModal } from "./ui.js";

export var errorFieldsLength = 0;


export class Transaction {
    static #nextId = 1;
    errorFields = [];
    constructor(amount, date, category, description) {
        this.id = Transaction.#nextId++;
        this.valid = true;
        this.setAmount(amount);
        this.setDate(date);
        this.setCategory(category);
        this.setDescription(description);
    }

    setAmount(amount) {
        try {
            const parsed = Number(amount);
            if (isNaN(parsed)) {
                throw new Error("Сумма должна быть числом, без букв!");
            }
            if (!Number.isInteger(parsed)) {
                throw new Error("Сумма должна быть целым числом!");
            }
            if (parsed === 0) {
                throw new Error("Сумма транзакции не может быть равна нулю!");
            }
            this.amount = parsed;
        } catch (error) {
            console.error("Amount Error:", error.message);
            this.errorFields.push(error.message);
            this.valid = false;
        }
    }

    setDate(date) {
        try {
            if (!date) {
                throw new Error("Вы не ввели дату!");
            }
            const currentDate = new Date();
            const inputDate = new Date(date);
            if (isNaN(inputDate.getTime())) {
                throw new Error("Некорректная дата!");
            }
            if (inputDate > currentDate) {
                throw new Error("Эта дата еще не наступила!");
            }
            this.date = date;
        } catch (error) {
            console.error("Date Error:", error.message);
            this.errorFields.push(error.message);
            this.valid = false;
        }
    }

    setCategory(category) {
        try {
            const categories = ["Еда", "Транспорт", "Развлечение", "Другое"];
            if (!categories.includes(category)) {
                throw new Error("Такой категории нет!");
            }
            this.category = category;
        } catch (error) {
            console.error("Category Error:", error.message);
            this.errorFields.push(error.message);
            this.valid = false;
        }
    }

    setDescription(description) {
        try {
            if (description.length === 0) {
                throw new Error("Описание не может быть пустым!");
            }
            if (description.length > 128) {
                throw new Error("Описание не может быть длиннее 128 символов!");
            }
            this.description = description;
        } catch (error) {
            console.error("Description Error:", error.message);
            this.errorFields.push(error.message);
            this.valid = false;
        }
    }

    formObject() {
        return {
            id: this.id,
            amount: this.amount,
            date: this.date,
            category: this.category,
            description: this.description
        };
    }
}




export function checkTransaction() {
    const date = document.querySelector("#Date");
    const amount = document.querySelector("#Amount");
    const category = document.querySelector("#Category");
    const description = document.querySelector("#Description");

    console.log("date:", date?.value);
    console.log("amount:", amount?.value);
    console.log("category:", category?.textContent);
    console.log("description:", description?.value);

    let newTransaction;

try {
    newTransaction = new Transaction(
        amount.value,
        date.value,
        category.textContent.trim(),
        description.value
    );
    if (!newTransaction.valid) {
        throw new Error("Транзакция содержит ошибки!");
    }
} catch (error) {
    const form = document.querySelector('form');

    form.addEventListener('submit', (e) => {
    e.preventDefault(); // ❗ останавливает отправку формы
    console.log("submit остановлен");
    });

    showModal(newTransaction.errorFields);
    console.error("Ошибка создания:", error.message);
    return;
}

return 1;
}

