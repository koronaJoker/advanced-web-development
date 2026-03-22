<?php

class TransactionTableRenderer
{
        public function render(array $transactions): string
        {
            $html = '<div class="table-container">';
            $html .= '<table>';

            $html .= '
        <thead>
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Amount</th>
            <th>Description</th>
            <th>Merchant</th>
            <th>DaysSinceTransaction</th>
        </tr>
        </thead>
        <tbody>
        ';

            foreach ($transactions as $t) {
                $html .= '<tr>';
                $html .= '<td>' . $t->getId() . '</td>';
                $html .= '<td>' . $t->getDate()->format("d.m.Y") . '</td>';
                $html .= '<td>' . $t->getAmount() . '</td>';
                $html .= '<td>' . $t->getDescription() . '</td>';
                $html .= '<td>' . $t->getMerchant() . '</td>';
                $html .= '<td>' . $t->getDaysSinceTransaction() . '</td>';
                $html .= '</tr>';
            }

            $html .= '</tbody></table></div>';

            return $html;
        }
    }