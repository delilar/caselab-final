<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Пройти опрос</title>
    <link rel="stylesheet" href="<?= $templateFolder ?>/style.css">
</head>
<body>
    <?php if (!empty($arResult["ERROR_MESSAGE"])): ?>
    <div class="vote-note-box vote-note-error">
        <div class="vote-note-box-text"><?= ShowError($arResult["ERROR_MESSAGE"]) ?></div>
    </div>
    <?php endif; ?>

    <?php if (!empty($arResult["OK_MESSAGE"])): ?>
    <div class="vote-note-box vote-note-note">
        <div class="vote-note-box-text"><?= ShowNote($arResult["OK_MESSAGE"]) ?></div>
    </div>
    <?php endif; ?>

    <?php if (empty($arResult["VOTE"])): return false; elseif (empty($arResult["QUESTIONS"])): return true; endif; ?>

    <div class="container">
        <div id="quiz">
            <form action="<?= POST_FORM_ACTION_URI ?>" method="post" class="vote-form">
                <input type="hidden" name="vote" value="Y">
                <input type="hidden" name="PUBLIC_VOTE_ID" value="<?= $arResult["VOTE"]["ID"] ?>">
                <input type="hidden" name="VOTE_ID" value="<?= $arResult["VOTE"]["ID"] ?>">
                <?= bitrix_sessid_post() ?>

                <?php foreach ($arResult["QUESTIONS"] as $index => $arQuestion): ?>
                <div class="slide">
                    <h2><?= $arQuestion["QUESTION"] ?><?php if ($arQuestion["REQUIRED"] == "Y") { echo "<span class='starrequired'>*</span>"; } ?></h2>
                    <?php foreach ($arQuestion["ANSWERS"] as $arAnswer): ?>
                    <label>
                        <?php switch ($arAnswer["FIELD_TYPE"]):
                            case 0: // radio ?>
                            <input type="radio" name="vote_radio_<?= $arAnswer["QUESTION_ID"] ?>" value="<?= $arAnswer["ID"] ?>"> <?= $arAnswer["MESSAGE"] ?>
                        <?php break; case 1: // checkbox ?>
                            <input type="checkbox" name="vote_checkbox_<?= $arAnswer["QUESTION_ID"] ?>[]" value="<?= $arAnswer["ID"] ?>"> <?= $arAnswer["MESSAGE"] ?>
                        <?php break; case 2: // dropdown ?>
                            <select name="vote_dropdown_<?= $arAnswer["QUESTION_ID"] ?>">
                                <option value=""><?= GetMessage("VOTE_DROPDOWN_SET") ?></option>
                                <?php foreach ($arAnswer["DROPDOWN"] as $arDropDown): ?>
                                <option value="<?= $arDropDown["ID"] ?>"><?= $arDropDown["MESSAGE"] ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php break; case 3: // multiselect ?>
                            <select name="vote_multiselect_<?= $arAnswer["QUESTION_ID"] ?>[]" multiple="multiple">
                                <?php foreach ($arAnswer["MULTISELECT"] as $arMultiSelect): ?>
                                <option value="<?= $arMultiSelect["ID"] ?>"><?= $arMultiSelect["MESSAGE"] ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php break; case 4: // text field ?>
                            <input type="text" name="vote_field_<?= $arAnswer["ID"] ?>" value=""> <?= $arAnswer["MESSAGE"] ?>
                        <?php break; case 5: // memo ?>
                            <textarea name="vote_memo_<?= $arAnswer["ID"] ?>"></textarea> <?= $arAnswer["MESSAGE"] ?>
                        <?php break; endswitch; ?>
                    </label>
                    <?php endforeach; ?>
                </div>
                <?php endforeach; ?>

                <?php if (isset($arResult["CAPTCHA_CODE"])): ?>
                <div class="vote-item-header">
                    <div class="vote-item-title vote-item-question"><?= GetMessage("F_CAPTCHA_TITLE") ?></div>
                    <div class="vote-clear-float"></div>
                </div>
                <div class="vote-form-captcha">
                    <input type="hidden" name="captcha_code" value="<?= $arResult["CAPTCHA_CODE"] ?>"/>
                    <div class="vote-reply-field-captcha-image">
                        <img src="/bitrix/tools/captcha.php?captcha_code=<?= $arResult["CAPTCHA_CODE"] ?>" alt="<?= GetMessage("F_CAPTCHA_TITLE") ?>" />
                    </div>
                    <div class="vote-reply-field-captcha-label">
                        <label for="captcha_word"><?= GetMessage("F_CAPTCHA_PROMT") ?><span class='starrequired'>*</span></label><br />
                        <input type="text" size="20" name="captcha_word" autocomplete="off" />
                    </div>
                </div>
                <?php endif; ?>

                <div class="vote-form-box-buttons vote-vote-footer">
                    <span class="vote-form-box-button vote-form-box-button-first">
                        <button type="button" id="prevBtn">Назад</button>
                    </span>
                    <span class="vote-form-box-button vote-form-box-button-last">
                        <button type="button" id="nextBtn">Далее</button>
                    </span>
                    <span class="vote-form-box-button vote-form-box-button-submit" style="display: none;">
                        <button type="submit" id="submitBtn">Голосовать</button>
                    </span>
                </div>
            </form>
        </div>
    </div>

    <!-- Модальное окно -->
    <dialog class="modal">
        <div class="modal-content">
            <p>Спасибо за прохождение опроса!</p>
            <button class="close">Закрыть</button>
        </div>
    </dialog>

    <script src="<?= $templateFolder ?>/script.js"></script>
</body>
</html>
