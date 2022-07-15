<?php
namespace IkechukwuOkalia;

if (!\function_exists("\\shell_exec")) {
  \trigger_error(
      "This class requires the function: `shell_exec`.",
      E_USER_ERROR
  );
  exit;
}
class cPanel {
  public final function createSubDomain (string $domain_part, string $root_domain, string $dir = "") {
    $shell = "uapi --output=jsonpretty SubDomain addsubdomain domain='{$domain_part}' rootdomain='{$root_domain}'";
    if (!empty($dir)) $shell .= " dir='{$dir}'";
    $shell .= " 2>&1";
    $result = \shell_exec($shell);
    if ($result && $result = \json_decode($result)) {
      $result = $result->result;
      if (empty($result->errors)) {
        return true;
      } else {
        throw new \Exception(\implode(" | ", $result->errors), 1);
      }
    }
    return false;
  } 
}