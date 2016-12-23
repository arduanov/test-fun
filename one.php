<?php

function parseSms($message)
{
    preg_match('#\d{14}#', $message, $matches);
    $account = array_shift($matches);
    $message = str_replace($account, '', $message, $count);
    if ($count > 1) {
        throw new \LogicException('Double account in message ' . $message);
    }

    preg_match('#\d+[,.]\d{2}#', $message, $matches);
    $amount_str = array_shift($matches);
    $amount = (float)str_replace(',', '.', $amount_str);
    $message = str_replace($amount_str, '', $message, $count);
    if ($count > 1) {
        throw new \LogicException('Double amount in message ' . $message);
    }

    preg_match('#\d{4}#', $message, $matches);
    $code = array_shift($matches);
    $message = str_replace($code, '', $message, $count);
    if ($count > 1) {
        throw new \LogicException('Double code in message ' . $message);
    }

    if (preg_match('#\d#', $message)) {
        throw new \LogicException('Unwanted digits in message ' . $message);
    }

    $result = compact('account', 'code', 'amount');
    foreach ($result as $k => $v) {
        if (strlen($v) < 3) {
            throw new \LogicException($k . '=`' . print_r($v, 1) . '` not valid in message ' . $message);
        }
    }

    return $result;
}