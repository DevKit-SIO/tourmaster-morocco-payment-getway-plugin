<?php
/**
 * CMI Payment Handler — WordPress-compatible version.
 */

namespace CMI\Payment;

use CMI\Payment\CmiPay;

class CmiHandler
{

    /**
     * Compute the CMI hash value for a payment request.
     *
     * @param CmiPay|array $cmiPay
     * @return string
     */
    public function hashValue($cmiPay, $sort = true): string
    {
        $storeKey = $cmiPay instanceof CmiPay ? $cmiPay->getSecretKey() : $cmiPay['secretKey'];
        $data = $cmiPay instanceof CmiPay ? $this->convertData($cmiPay) : $cmiPay;
        $data = $this->unsetData($data);

        $postParams = array();
        foreach ($data as $key => $value) {
            array_push($postParams, $key);
        }
        natcasesort($postParams);

        $hashval = "";
        foreach ($postParams as $param) {
            $paramValue = html_entity_decode(preg_replace("/\n$/","",$data[$param]), ENT_QUOTES, 'UTF-8'); 

            $escapedParamValue = str_replace("|", "\\|", str_replace("\\", "\\\\", $paramValue));

            $lowerParam = strtolower($param);
            
            // $paramValue = trim(urldecode(preg_replace("/\n$/", "", $data[$param])));
            // $escapedParamValue = str_replace("|", "\\|", str_replace("\\", "\\\\", $paramValue));

            // $lowerParam = strtolower($param);
            if ($lowerParam != "hash" && $lowerParam != "encoding") {
                $hashval .= $escapedParamValue . "|";
            }
        }

        $escapedStoreKey = str_replace("|", "\\|", str_replace("\\", "\\\\", $storeKey));
        $hashval = $hashval . $escapedStoreKey;

        $calculatedHashValue = hash('sha512', $hashval);
        $hash = base64_encode(pack('H*', $calculatedHashValue));

        return $hash;
    }

    /**
     * Convert a CmiPay object into a flat associative array, the same way
     * Symfony's GetSetMethodNormalizer + json encode/decode round-trip did:
     * for every public getX()/isX() method, call it and store the result
     * under the lowercased property name "x".
     *
     * @param CmiPay $params
     * @return array
     */
    public function convertData(CmiPay $params): array
    {
        $data = array();

        $reflection = new \ReflectionClass($params);

        foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
            $methodName = $method->getName();

            // var_dump($methodName);

            // Skip constructor/destructor and anything that takes required args.
            if ($method->isStatic() || $method->isAbstract()) {
                continue;
            }
            if ($method->getNumberOfRequiredParameters() > 0) {
                continue;
            }

            $propertyName = null;

            if (preg_match('/^get([A-Za-z0-9_].*)$/', $methodName, $matches)) {
                $propertyName = $matches[1];
            } elseif (preg_match('/^is([A-Za-z0-9_].*)$/', $methodName, $matches)) {
                $propertyName = $matches[1];
            }

            if ($propertyName === null) {
                continue;
            }
            if (in_array($methodName, array('getIterator', 'getInstance'), true)) {
                continue;
            }

            // Match Symfony's GetSetMethodNormalizer key casing: first
            // character lowercased, rest of the name left as-is
            // (getClientid -> clientid, getSecretKey -> secretKey).
            $key = $propertyName !== "TranType" ? lcfirst($propertyName) : ucfirst($propertyName);

            $value = $method->invoke($params);

            // Symfony's normalizer would drop methods that don't return
            // scalar-ish data cleanly when serialized to JSON; here we just
            // skip null and non-scalar (array/object) results to keep the
            // flat-array shape the rest of this class expects.
            if (is_array($value) || is_object($value)) {
                continue;
            }

            $data[$key] = $value;
        }

        foreach ($data as $key => $value) {
            $data[$key] = trim(html_entity_decode((string)$value, ENT_QUOTES, 'UTF-8'));
        }

        return $data;
    }

    /**
     * Remove sensitive / non-transmittable fields before hashing/posting.
     *
     * @param array $data
     * @return array
     */
    public function unsetData(array $data): array
    {
        unset($data['gatewayurl'], $data['secretKey']);
        return $data;
    }
}