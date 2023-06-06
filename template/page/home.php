<?php

declare(strict_types=1);

use adRespect\View\View;
use adRespect\Rules\RouterRules;

$viewData = View::data();
$viewValue = View::values();

$calculationResult = $viewValue['calculation_result'] ?? '';
$currencyFor = $viewValue['request']['currency']['for'] ?? '';
$currencyFrom = $viewValue['request']['currency']['from'] ?? '';
$amount = $viewValue['request']['amount'] ?? '';
$calculatedExchangeList = $viewValue['calculated_exchange']['list'];
$amount = str_replace('.', ',', (string)$amount);

?>

<main>
    <?php if ($viewValue['currency']['rows'] === 0): ?>

        <h1>Brak aktualnych kursów.</h1>

    <?php else: ?>

        <h1>Kalkulator</h1>

        <form action="<?= RouterRules::viewLink('page', 'calculation') ?>" method="post">
            <fieldset>
                <legend>Obecnie <?= $viewValue['currency']['rows'] ?> walut!</legend>

                <div class="wrap">
                    <label for="amount-in">Kwota:</label>
                    <input type="text" id="amount-in" name="amount[]" pattern="^[0-9]*(,[0-9]{0,2})?$" placeholder="Wpisz kwotę" value="<?= $amount ?>" required>
                </div>

            </fieldset>

            <fieldset>
                <div class="wrap">
                    <label for="amount-out">Z waluty:</label>
                    <select name="currency[from]" id="currency-out" required>
                        <optgroup label="Podstawowe">

                            <option value="">Wybierz walutę</option>

                            <?php if ($currencyFrom === 'PLN'): ?>
                                <option selected value="PLN">PLN - nowe złote</option>
                            <?php else: ?>
                                <option value="PLN">PLN - nowe złote</option>
                            <?php endif; ?>

                            <?php foreach ($viewValue['currency']['list']['A'] as $rowA): ?>

                                <?php if ($currencyFrom === $rowA['code']): ?>
                                    <option selected value="<?= $rowA['code'] ?>"><?= $rowA['code'] . ' - ' . $rowA['currency'] ?></option>
                                <?php else: ?>
                                    <option value="<?= $rowA['code'] ?>"><?= $rowA['code'] . ' - ' . $rowA['currency'] ?></option>
                                <?php endif; ?>

                            <?php endforeach; ?>

                        </optgroup>
                        <optgroup label="Pozostałe">

                            <?php foreach ($viewValue['currency']['list']['B'] as $rowB): ?>

                                <?php if ($currencyFrom === $rowB['code']): ?>
                                    <option selected value="<?= $rowB['code'] ?>"><?= $rowB['code'] . ' - ' . $rowB['currency'] ?></option>
                                <?php else: ?>
                                    <option value="<?= $rowB['code'] ?>"><?= $rowB['code'] . ' - ' . $rowB['currency'] ?></option>
                                <?php endif; ?>

                            <?php endforeach; ?>

                        </optgroup>
                    </select>
                </div>

                <div class="wrap">
                    <label for="currency-in">Na walutę:</label>
                    <select name="currency[for]" id="currency-in" required>
                        <optgroup label="Podstawowe">

                            <option value="">Wybierz walutę</option>

                            <?php if ($currencyFor === 'PLN'): ?>
                                <option selected value="PLN">PLN - nowe złote</option>
                            <?php else: ?>
                                <option value="PLN">PLN - nowe złote</option>
                            <?php endif; ?>

                            <?php foreach ($viewValue['currency']['list']['A'] as $rowA): ?>

                                <?php if ($currencyFor === $rowA['code']): ?>
                                    <option selected value="<?= $rowA['code'] ?>"><?= $rowA['code'] . ' - ' . $rowA['currency'] ?></option>
                                <?php else: ?>
                                    <option value="<?= $rowA['code'] ?>"><?= $rowA['code'] . ' - ' . $rowA['currency'] ?></option>
                                <?php endif; ?>

                            <?php endforeach; ?>

                        </optgroup>
                        <optgroup label="Pozostałe">

                            <?php foreach ($viewValue['currency']['list']['B'] as $rowB): ?>

                                <?php if ($currencyFor === $rowB['code']): ?>
                                    <option selected value="<?= $rowB['code'] ?>"><?= $rowB['code'] . ' - ' . $rowB['currency'] ?></option>
                                <?php else: ?>
                                    <option value="<?= $rowB['code'] ?>"><?= $rowB['code'] . ' - ' . $rowB['currency'] ?></option>
                                <?php endif; ?>

                            <?php endforeach; ?>

                        </optgroup>
                    </select>
                </div>
            </fieldset>

            <fieldset>
                <button type="submit">Przelicz</button>
            </fieldset>
        </form>

        <section class="messages">
            <?php if (!empty($viewValue['message'])) : ?>
                <aside>
                    <ul>
                        <?php foreach ($viewValue['message'] as $message): ?>
                            <li><?= $message ?></li>
                        <?php endforeach; ?>
                    </ul>
                </aside>
            <?php endif; ?>

            <?php if (!empty($calculationResult)) : ?>
                <div class="result">
                    <h2>Kwota: <?= $amount . ' ' . $currencyFrom ?></h2>
                    <h2>Kwota po przeliczeniu: <?= $calculationResult . ' ' . $currencyFor ?></h2>
                </div>
            <?php endif; ?>
        </section>

    <?php endif; ?>

    <section>
        <h3>Ostanie wyliczenia</h3>
        <table>
            <thead>
            <tr>
                <th>Kwota</th>
                <th>Na walutę</th>
                <th>Według kursu</th>
                <th>Kwota po przeliczeniu</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($calculatedExchangeList as $rowC): ?>
                <tr>
                    <td><?= number_format((float)$rowC['amount_from'], 2, ',', '') . ' ' . $rowC['currency_from'] ?></td>
                    <td><?= $rowC['currency_for'] ?></td>
                    <td><?= '1 ' . $rowC['currency_from'] . ' = ' . number_format(($rowC['amount'] / $rowC['amount_from']), 4, ',', '') . ' ' . $rowC['currency_for'] ?></td>
                    <td><?= number_format((float)$rowC['amount'], 2, ',', '') . ' ' . $rowC['currency_for'] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </section>

</main>