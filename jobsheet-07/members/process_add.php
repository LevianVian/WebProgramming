<?php
session_start();

$name = trim($_POST['name'] ?? '');
$memberId = trim($_POST['member_id'] ?? '');
$address = trim($_POST['address'] ?? '');
$phone = trim($_POST['phone'] ?? '');

$errors = [];

// Validator buat nama yang harus huruf sama spasi aja
if ($name === '') {
    $errors[] = "Name is required.";
} elseif (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
    $errors[] = "Name can only contain letters and spaces.";
}

// Validator buat member ID yang harus pakai angka dan ada minimum 8 karakter
if ($memberId === '') {
    $errors[] = "Member ID is required.";
} elseif (!is_numeric($memberId) || strlen($memberId) < 8) {
    $errors[] = "Member ID must be numeric and at least 8 characters long.";
}

if ($address === '') {
    $errors[] = "Address is required.";
}

if ($phone !== '' && !is_numeric($phone)) {
    $errors[] = "Phone number can only contain digits.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'message' => implode(' ', $errors)];
    header('Location: add.php');
    exit;
}

if (!isset($_SESSION['members'])) {
    $_SESSION['members'] = [];
}

$_SESSION['members'][] = [
    'name' => $name,
    'member_id' => $memberId,
    'address' => $address,
    'phone' => $phone,
];

// Success Flash Message sama Redirect nya
$_SESSION['flash'] = ['type' => 'success', 'message' => 'Member added successfully.'];
header('Location: list.php');
exit;