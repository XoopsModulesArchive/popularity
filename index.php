<?php

include '../../mainfile.php';
include $xoopsConfig['root_path'] . 'header.php';
$xoopsOption['show_rblock'] = 0;

$pagetitle = '- ' . _POPULARITY . '';

global $user;

echo '<center><h3>' . _POPULARITY . '</h3></center>';

if ($lesite) {
    $url = (string)$lesite;
} else {
    $url = 'www.';

    $mot = '' . _WAITTING . '';
}

echo "<form action=\"index.php\" method=\"post\">
<center>http://<input type=\"text\" name=\"lesite\" value=\"$url\" size=\"40\">&nbsp;&nbsp;&nbsp;<input type=\"submit\" value=\"" . _COUNT . "\">
<br>$mot
</center>
</form>";
echo '<center>' . _EXPLICATION . ' <br><br> ' . _EXPLICATION2 . '</center><br><br>';

if ($lesite) {
    // Moteur de recherche Lycos

    $lycos = implode('', file("http://search.lycos.com/default.asp?loc=searchbox&query=linkdomain%3A$lesite"));

    $lycos = mb_strstr($lycos, '1 thru 10 of '); // Coupe avant 1 thru 10 of
$lycos = mb_substr($lycos, 12);  // Efface le 1 thru 10 of
$pos = mb_strpos($lycos, '<');  // Calcule le nombre de caracteres pour arriver au premier < apres le chiffre désiré
$lycos = mb_substr($lycos, 0, $pos); // efface ce qu'il y a apres
$lycos = preg_replace(',', '', $lycos); // efface les virgules
$lycos = trim($lycos); // Enlève les espaces dans le résultat

// Moteur de recherche HotBot

    $hotbot = implode('', file("http://www.hotbot.lycos.com/?query=linkdomain:$lesite&cobrand=&matchmode=all&datedelta=0&language=any&descriptiontype=2&modsign1=MC"));

    $hotbot = mb_strstr($hotbot, '1 - 10 of '); // Coupe avant 1 - 10 of
$hotbot = mb_substr($hotbot, 10);  // Efface le 1 - 10 of
$pos = mb_strpos($hotbot, ')');  // Calcule le nombre de caracteres pour arriver au premier ) apres le chiffre désiré
$hotbot = mb_substr($hotbot, 0, $pos); // efface ce qu'il y a apres
$hotbot = preg_replace(',', '', $hotbot); // efface les virgules
$hotbot = trim($hotbot); // Enlève les espaces dans le résultat

// Moteur de recherche MSN

    $msn = implode('', file("http://search.msn.com/results.asp?RS=CHECKED&FORM=MSNH&v=1&q=linkdomain%3A$lesite"));

    $msn = mb_strstr($msn, '1-15 of about'); // Coupe avant 1-15 of about
$msn = mb_substr($msn, 13);  // Efface le 1-15 of about
$pos = mb_strpos($msn, 'c');  // Calcule le nombre de caracteres pour arriver au premier c apres le chiffre désiré
$msn = mb_substr($msn, 0, $pos); // efface ce qu'il y a apres
$msn = preg_replace(',', '', $msn); // efface les virgules
$msn = trim($msn); // Enlève les espaces dans le résultat

// Moteur de recherche AOL

    $aol = implode('', file("http://search.aol.com/aolcom/search?query=link%3A$lesite&invocationType=topsearchbox.%2Findex.adp"));

    $aol = mb_strstr($aol, 'Page 1&nbsp;of&nbsp;'); // Coupe avant Page 1 of
$aol = mb_substr($aol, 20);  // Efface le Page 1 of
$pos = mb_strpos($aol, ')');  // Calcule le nombre de caracteres pour arriver au premier ) apres le chiffre désiré
$aol = mb_substr($aol, 0, $pos); // efface ce qu'il y a apres
$aol = preg_replace(',', '', $aol); // efface les virgules
$aol = trim($aol); // Enlève les espaces dans le résultat
$aol = ($aol - 1) * 15 + 10;

    // Moteur de recherche AltaVista

    $altavista = implode('', file("http://fr.altavista.com/web/results?q=link%3A$lesite&kgs=0&kls=0&avkw=qtrp"));

    $altavista = mb_strstr($altavista, 'AltaVista a trouvé '); // Coupe avant AltaVista a trouvé
$altavista = mb_substr($altavista, 18);  // Efface le AltaVista a trouvé
$pos = mb_strpos($altavista, 'r');  // Calcule le nombre de caracteres pour arriver au premier r apres le chiffre désiré
$altavista = mb_substr($altavista, 0, $pos); // efface ce qu'il y a apres
$altavista = preg_replace(',', '', $altavista); // efface les virgules
$altavista = trim($altavista); // Enlève les espaces dans le résultat

// Moteur de recherche AlltheWeb

    $alltheweb = implode('', file("http://www.alltheweb.com/search?cat=web&cs=utf-8&q=link.all%3A$lesite&_sb_lang=any"));

    $alltheweb = mb_strstr($alltheweb, 'of <span class="ofSoMany">'); // Coupe avant of <span class="ofSoMany">
$alltheweb = mb_substr($alltheweb, 26);  // Efface le of <span class="ofSoMany">
$pos = mb_strpos($alltheweb, '<');  // Calcule le nombre de caracteres pour arriver au premier < apres le chiffre désiré
$alltheweb = mb_substr($alltheweb, 0, $pos); // efface ce qu'il y a apres
$alltheweb = preg_replace(',', '', $alltheweb); // efface les virgules
$alltheweb = trim($alltheweb); // Enlève les espaces dans le résultat

$query = "link:$lesite";

    // make errors handle properly in windows (thx, thong@xmethods.com)

    error_reporting(2039);

    // set default encoding

    $soap_defencoding = 'UTF-8';

    // set schema version

    $XMLSchemaVersion = 'http://www.w3.org/2001/XMLSchema';

    // load types into typemap array

    $typemap['http://www.w3.org/2001/XMLSchema'] = [
    'string', 'boolean', 'float', 'double', 'decimal', 'duration', 'dateTime', 'time',
    'date', 'gYearMonth', 'gYear', 'gMonthDay', 'gDay', 'gMonth', 'hexBinary', 'base64Binary',
    // derived datatypes
    'normalizedString', 'token', 'language', 'NMTOKEN', 'NMTOKENS', 'Name', 'NCName', 'ID',
    'IDREF', 'IDREFS', 'ENTITY', 'ENTITIES', 'integer', 'nonPositiveInteger',
    'negativeInteger', 'long', 'int', 'short', 'byte', 'nonNegativeInteger',
    'unsignedLong', 'unsignedInt', 'unsignedShort', 'unsignedByte', 'positiveInteger',
];

    $typemap['http://www.w3.org/1999/XMLSchema'] = [
    'i4', 'int', 'boolean', 'string', 'double', 'float', 'dateTime',
    'timeInstant', 'base64Binary', 'base64', 'ur-type',
];

    $typemap['http://soapinterop.org/xsd'] = ['SOAPStruct'];

    $typemap['http://schemas.xmlsoap.org/soap/encoding/'] = ['base64', 'array', 'Array'];

    // load namespace uris into an array of uri => prefix

    $namespaces = [
    'http://schemas.xmlsoap.org/soap/envelope/' => 'SOAP-ENV',
$XMLSchemaVersion => 'xsd',
$XMLSchemaVersion . '-instance' => 'xsi',
'http://schemas.xmlsoap.org/soap/encoding/' => 'SOAP-ENC',
'http://soapinterop.org/xsd' => 'si',
];

    $xmlEntities = [
'quot' => '"',
'amp' => '&',
'lt' => '<',
'gt' => '>',
'apos' => "'",
];

    // $path can be a complete endpoint url, with the other parameters left blank:

    // $soap_client = new soap_client("http://path/to/soap/server");

    class soap_client
    {
        public function __construct($path, $server = false, $port = false)
        {
            $this->port = 80;

            $this->path = $path;

            $this->server = $server;

            $this->errno;

            $this->errstring;

            $this->debug_flag = false;

            $this->debug_str = '';

            $this->username = '';

            $this->password = '';

            $this->action = '';

            $this->incoming_payload = '';

            $this->outgoing_payload = '';

            $this->response = '';

            $this->action = '';

            // endpoint mangling

            if (preg_match('^http://', $path)) {
                $path = str_replace('http://', '', $path);

                $this->path = mb_strstr($path, '/');

                $this->debug("path = $this->path");

                if (preg_match(':', $path)) {
                    $this->server = mb_substr($path, 0, mb_strpos($path, ':'));

                    $this->port = mb_substr(mb_strstr($path, ':'), 1);

                    $this->port = mb_substr($this->port, 0, mb_strpos($this->port, '/'));
                } else {
                    $this->server = mb_substr($path, 0, mb_strpos($path, '/'));
                }
            }

            if ($port) {
                $this->port = $port;
            }
        }

        public function setCredentials($username, $pword)
        {
            $this->username = $username;

            $this->password = $pword;
        }

        public function send($msg, $action = '', $timeout = 0)
        {
            // where msg is an soapmsg

            if ($this->debug_flag) {
                $msg->debug_flag = true;
            }

            $this->action = $action;

            return $this->sendPayloadHTTP10(
                $msg,
                $this->server,
                $this->port,
                $timeout,
                $this->username,
                $this->password
            );
        }

        public function sendPayloadHTTP10($msg, $server, $port, $timeout = 0, $username = '', $password = '')
        {
            if ($timeout > 0) {
                $fp = fsockopen($server, $port, $this->errno, $this->errstr, $timeout);
            } else {
                $fp = fsockopen($server, $port, $this->errno, $this->errstr);
            }

            if (!$fp) {
                $this->debug("Couldn't open socket connection to server!");

                $this->debug("Server: $this->server");

                return 0;
            }

            $credentials = '';

            if ('' != $username) {
                $credentials = 'Authorization: Basic ' . base64_encode("$username:$password") . "\r\n";
            }

            $soap_data = $msg->serialize();

            $this->outgoing_payload = 'POST ' . $this->path . " HTTP/1.0\r\n" .
            "User-Agent: SOAPx4 v0.5\r\n" .
            'Host: ' . $this->server . "\r\n" .
            $credentials .
            "Content-Type: text/xml\r\nContent-Length: " . mb_strlen($soap_data) . "\r\n" .
            "SOAPAction: \"$this->action\"" . "\r\n\r\n" .
            $soap_data;

            // send

            if (!fwrite($fp, $this->outgoing_payload, mb_strlen($this->outgoing_payload))) {
                $this->debug('Write error');
            }

            // get reponse

            while ($data = fread($fp, 32768)) {
                $incoming_payload .= $data;
            }

            fclose($fp);

            $this->incoming_payload = $incoming_payload;

            // $response is a soapmsg object

            $this->response = $msg->parseResponse($incoming_payload);

            $this->debug($msg->debug_str);

            return $this->response;
        }

        public function debug($string)
        {
            if ($this->debug_flag) {
                $this->debug_str .= "soap_client: $string\n";
            }
        }
    } // end class soap_client

    // soap message class

    class soapmsg
    {
        // params is an array of soapval objects

        public function __construct($method, $params, $method_namespace = 'http://testuri.org', $new_namespaces = false)
        {
            // globalize method namespace

            global $methodNamespace;

            $methodNamespace = $method_namespace;

            // make method struct

            $this->value = new soapval($method, 'struct', $params, $method_namespace);

            if (is_array($new_namespaces)) {
                global $namespaces;

                $i = count($namespaces);

                foreach ($new_namespaces as $v) {
                    $namespaces[$v] = 'ns' . $i++;
                }

                $this->namespaces = $namespaces;
            }

            $this->payload = '';

            $this->debug_flag = false;

            $this->debug_str = 'entering soapmsg() with soapval ' . $this->value->name . "\n";
        }

        public function make_envelope($payload)
        {
            global $namespaces;

            foreach ($namespaces as $k => $v) {
                $ns_string .= "xmlns:$v=\"$k\" ";
            }

            return "<SOAP-ENV:Envelope $ns_string SOAP-ENV:encodingStyle=\"http://schemas.xmlsoap.org/soap/encoding/\">\n" .
               $payload .
               "</SOAP-ENV:Envelope>\n";
        }

        public function make_body($payload)
        {
            return "<SOAP-ENV:Body>\n" .
                $payload .
                "</SOAP-ENV:Body>\n";
        }

        public function createPayload()
        {
            $value = $this->value;

            $payload = $this->make_envelope($this->make_body($value->serialize()));

            $this->debug($value->debug_str);

            $payload = "<?xml version=\"1.0\"?>\n" . $payload;

            if ($this->debug_flag) {
                $payload .= $this->serializeDebug();
            }

            $this->payload = str_replace("\n", "\r\n", $payload);
        }

        public function serialize()
        {
            if ('' == $this->payload) {
                $this->createPayload();

                return $this->payload;
            }

            return $this->payload;
        }

        // returns a soapval object

        public function parseResponse($data)
        {
            $this->debug('Entering parseResponse()');

            //$this->debug(" w/ data $data");

            if (preg_match("^(.*)\r\n\r\n", $data)) {
                $this->debug('found proper separation of headers and document');

                $this->debug('getting rid of headers, stringlen: ' . mb_strlen($data));

                // CHANGES BELOW

                $offset = mb_strpos($data, "\r\n\r\n<");

                $clean_data = mb_substr($data, $offset + 2);

                $clean_data = preg_replace("\r\n", '', $clean_data);

                //$clean_data = preg_replace("^.*\r\n\r\n", "", $data);

                //$clean_data = preg_replace("^.*\r\n\r\n<","<", $data);

                $this->debug('cleaned data, stringlen: ' . mb_strlen($clean_data));

            //$this->debug($clean_data);
            } else {
                // return fault

                return new soapval('fault', 'SOAPStruct', [new soapval('faultcode', 'string', 'SOAP-MSG'), new soapval('faultstring', 'string', 'HTTP error'), new soapval('faultdetail', 'string', "HTTP headers were not immediately followed by '\r\n\r\n'")]);
            }

            $this->debug('about to create parser instance w/ data');

            // parse response

            $response = new soap_parser($clean_data);

            // return array of parameters

            $ret = $response->get_response();

            $this->debug($response->debug_str);

            return $ret;
        }

        // dbg

        public function debug($string)
        {
            if ($this->debug_flag) {
                $this->debug_str .= "soapmsg: $string\n";
            }
        }

        // preps debug data for encoding into soapmsg

        public function serializeDebug()
        {
            if ($this->debug_flag) {
                return "<!-- DEBUG INFO:\n" . $this->debug_str . "-->\n";
            }

            return '';
        }
    }

    // soap value object

    class soapval
    {
        public function __construct($name = '', $type = false, $value = -1, $namespace = false, $type_namespace = false)
        {
            global $soapTypes, $typemap, $namespaces, $methodNamespace, $XMLSchemaVersion;

            // detect type if not passed

            if (!$type) {
                $this->debug("soapval - DETECT TYPE: '$name' type: '$type' value: $value\n");

                if (is_array($value) && count($value) >= 1) {
                    foreach ($value as $k => $v) {
                        if (preg_match('^[0-9]+$', $k)) {
                            $type = 'array';
                        } else {
                            $type = 'struct';
                        }

                        break;
                    }
                } elseif (is_int($value)) {
                    $type = 'int';
                } elseif (is_float($value) || 'NaN' == $value || 'INF' == $value) {
                    $type = 'float';
                } else {
                    $type = gettype($value);
                }
            }

            // php type name mangle

            if ('integer' == $type) {
                $type = 'int';
            }

            $this->soapTypes = $soapTypes;

            $this->name = $name;

            $this->value = '';

            $this->type = $type;

            $this->type_code = 0;

            $this->type_prefix = false;

            $this->array_type = '';

            $this->debug_flag = true;

            $this->debug_str = '';

            $this->debug("Entering soapval - name: '$name' type: '$type' value: $value");

            if ($namespace) {
                $this->namespace = $namespace;

                if (!isset($namespaces[$namespace])) {
                    $namespaces[$namespace] = 'ns' . (count($namespaces) + 1);
                }

                $this->prefix = $namespaces[$namespace];
            }

            // get type prefix

            if (preg_match(':', $type)) {
                $this->type = mb_substr(mb_strrchr($type, ':'), 1, mb_strlen(mb_strrchr($type, ':')));

                $this->type_prefix = mb_substr($type, 0, mb_strpos($type, ':'));
            } elseif ($type_namespace) {
                if (!isset($namespaces[$type_namespace])) {
                    $namespaces[$type_namespace] = 'ns' . (count($namespaces) + 1);
                }

                $this->type_prefix = $namespaces[$type_namespace];

            // if type namespace was not explicitly passed, and we're not in a method struct:
            } elseif (!$this->type_prefix && !isset($this->namespace)) {
                // try to get type prefix from typeMap

                if (!$ns = $this->verify_type($type)) {
                    // else default to method namespace

                    $this->type_prefix = $namespaces[$methodNamespace];
                } else {
                    $this->type_prefix = $namespaces[$ns];
                }
            }

            // if scalar

            if (in_array($this->type, $typemap[$XMLSchemaVersion], true)) {
                $this->type_code = 1;

                $this->addScalar($value, $this->type, $name);

            // if array
            } elseif (eregi('^(array|ur-type)$', $this->type)) {
                $this->type_code = 2;

                $this->addArray($value);

            // if struct
            } elseif (eregi('struct', $this->type)) {
                $this->type_code = 3;

                $this->addStruct($value);
            } elseif (is_array($value)) {
                $this->type_code = 3;

                $this->addStruct($value);
            } else {
                $this->type_code = 1;

                $this->addScalar($value, 'string', $name);
            }
        }

        public function addScalar($value, $type, $name = '')
        {
            $this->debug("adding scalar '$name' of type '$type'");

            $this->value = $value;

            return true;
        }

        public function addArray($vals)
        {
            $this->debug("adding array '$this->name' with " . count($vals) . ' vals');

            $this->value = [];

            if (is_array($vals) && count($vals) >= 1) {
                foreach ($vals as $k => $v) {
                    $this->debug("checking value $k : $v");

                    // if soapval, add..

                    if ('soapval' == get_class($v)) {
                        $this->value[] = $v;

                        $this->debug($v->debug_str);

                    // else make obj and serialize
                    } else {
                        if (is_array($v)) {
                            if (preg_match("[a-zA-Z\-]*", key($v))) {
                                $type = 'struct';
                            } else {
                                $type = 'array';
                            }
                        } elseif (!preg_match('^[0-9]+$', $k) && $this->verify_type($k)) {
                            $type = $k;
                        } elseif (is_int($v)) {
                            $type = 'int';
                        } elseif (is_float($v) || 'NaN' == $v || 'INF' == $v) {
                            $type = 'float';
                        } else {
                            $type = gettype($v);
                        }

                        $new_val = new self('item', $type, $v);

                        $this->debug($new_val->debug_str);

                        $this->value[] = $new_val;
                    }
                }
            }

            return true;
        }

        public function addStruct($vals)
        {
            $this->debug("adding struct '$this->name' with " . count($vals) . ' vals');

            if (is_array($vals) && count($vals) >= 1) {
                foreach ($vals as $k => $v) {
                    // if serialize, if soapval

                    if ('soapval' == get_class($v)) {
                        $this->value[] = $v;

                        $this->debug($v->debug_str);

                    // else make obj and serialize
                    } else {
                        if (is_array($v)) {
                            foreach ($v as $a => $b) {
                                if ('0' == $a) {
                                    $type = 'array';
                                } else {
                                    $type = 'struct';
                                }

                                break;
                            }
                        } elseif ($this->verify_type($k)) {
                            $this->debug("got type '$type' for value '$v' from typemap!");

                            $type = $k;
                        } elseif (is_int($v)) {
                            $type = 'int';
                        } elseif (0 && (is_float($v) || 'NaN' == $v || 'INF' == $v)) {//MODIFIED: Mike Agar, to work with Google
                            $type = 'float';
                        } else {
                            $type = gettype($v);

                            if ('boolean' == $type) {//MODIFIED: Mike Agar, to work with Google
                                switch ($v) {
                                case 0:
                                case false:
                                case '':
                                    $v = 'false';
                                    break;
                                default:
                                    $v = 'true';
                                    break;
                            }
                            }

                            $this->debug("got type '$type' for value '$v' from php gettype()!");
                        }

                        $new_val = new self($k, $type, $v);

                        $this->debug($new_val->debug_str);

                        $this->value[] = $new_val;
                    }
                }
            } else {
                $this->value = [];
            }

            return true;
        }

        // turn soapvals into xml, woohoo!

        public function serializeval($soapval = false)
        {
            if (!$soapval) {
                $soapval = $this;
            }

            $this->debug("serializing '$soapval->name' of type '$soapval->type'");

            if (is_int($soapval->name)) {
                $soapval->name = 'item';
            }

            switch ($soapval->type_code) {
            case 3:
                // struct
                $this->debug('got a struct');
                if ($soapval->prefix && $soapval->type_prefix) {
                    $xml .= "<$soapval->prefix:$soapval->name xsi:type=\"$soapval->type_prefix:$soapval->type\">\n";
                } elseif ($soapval->type_prefix) {
                    $xml .= "<$soapval->name xsi:type=\"$soapval->type_prefix:$soapval->type\">\n";
                } elseif ($soapval->prefix) {
                    $xml .= "<$soapval->prefix:$soapval->name>\n";
                } else {
                    $xml .= "<$soapval->name>\n";
                }
                if (is_array($soapval->value)) {
                    foreach ($soapval->value as $k => $v) {
                        $xml .= $this->serializeval($v);
                    }
                }
                if ($soapval->prefix) {
                    $xml .= "</$soapval->prefix:$soapval->name>\n";
                } else {
                    $xml .= "</$soapval->name>\n";
                }
                break;
            case 2:
                // array
                foreach ($soapval->value as $array_val) {
                    $array_types[$array_val->type] = 1;

                    $xml .= $this->serializeval($array_val);
                }
                if (count($array_types) > 1) {
                    $array_type = 'xsd:ur-type';
                } elseif (count($array_types) >= 1) {
                    if ('' != $array_val->type_prefix) {
                        $array_type = $array_val->type_prefix . ':' . $array_val->type;
                    } else {
                        $array_type = $array_val->type;
                    }
                }

                $xml = "<$soapval->name xsi:type=\"SOAP-ENC:Array\" SOAP-ENC:arrayType=\"" . $array_type . '[' . count($soapval->value) . "]\">\n" . $xml . "</$soapval->name>\n";
                break;
            case 1:
                $xml .= "<$soapval->name xsi:type=\"$soapval->type_prefix:$soapval->type\">$soapval->value</$soapval->name>\n";
                break;
            default:
                break;
        }

            return $xml;
        }

        // serialize

        public function serialize()
        {
            return $this->serializeval($this);
        }

        public function decode($soapval = false)
        {
            if (!$soapval) {
                $soapval = $this;
            }

            $this->debug("inside soapval->decode for $soapval->name of type $soapval->type and value: $soapval->value");

            // scalar decode

            if (1 == $soapval->type_code) {
                return $soapval->value;
            // array decode
            } elseif (2 == $soapval->type_code) {
                if (is_array($soapval->value)) {
                    foreach ($soapval->value as $item) {
                        $return[] = $this->decode($item);
                    }

                    return $return;
                }

                return [];
            // struct decode
            } elseif (3 == $soapval->type_code) {
                if (is_array($soapval->value)) {
                    foreach ($soapval->value as $item) {
                        $return[$item->name] = $this->decode($item);
                    }

                    return $return;
                }

                return [];
            }
        }

        // pass it a type, and it attempts to return a namespace uri

        public function verify_type($type)
        {
            global $typemap,$namespaces,$XMLSchemaVersion;

            /*foreach($typemap as $namespace => $types){
            	if(is_array($types) && in_array($type,$types)){
            		return $namespace;
            	}
            }*/

            foreach ($namespaces as $uri => $prefix) {
                if (is_array($typemap[$uri]) && in_array($type, $typemap[$uri], true)) {
                    return $uri;
                }
            }

            return false;
        }

        // alias for verify_type() - pass it a type, and it returns it's prefix

        public function get_prefix($type)
        {
            if ($prefix = $this->verify_type($type)) {
                return $prefix;
            }

            return false;
        }

        public function debug($string)
        {
            if ($this->debug_flag) {
                $this->debug_str .= "soapval: $string\n";
            }
        }
    }

    class soap_parser
    {
        public function __construct($xml, $encoding = 'UTF-8')
        {
            //global $soapTypes;

            //$this->soapTypes = $soapTypes;

            $this->xml = $xml;

            $this->xml_encoding = $encoding;

            $this->root_struct = '';

            // determines where in the message we are (envelope,header,body,method)

            $this->status = '';

            $this->position = 0;

            $this->pos_stat = 0;

            $this->depth = 0;

            $this->default_namespace = '';

            $this->namespaces = [];

            $this->message = [];

            $this->fault = false;

            $this->fault_code = '';

            $this->fault_str = '';

            $this->fault_detail = '';

            $this->depth_array = [];

            $this->debug_flag = true;

            $this->debug_str = '';

            $this->previous_element = '';

            $this->soapresponse = null;

            $this->entities = [
'&' => '&amp;',
'<' => '&lt;',
'>' => '&gt;',
"'" => '&apos;',
'"' => '&quot;',
];

            // Check whether content has been read.

            if (!empty($xml)) {
                $this->debug('Entering soap_parser()');

                //$this->debug("DATA DUMP:\n\n$xml");

                // Create an XML parser.

                $this->parser = xml_parser_create($this->xml_encoding);

                // Set the options for parsing the XML data.

                //xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);

                xml_parser_set_option($this->parser, XML_OPTION_CASE_FOLDING, 0);

                // Set the object for the parser.

                xml_set_object($this->parser, $this);

                // Set the element handlers for the parser.

                xml_set_elementHandler($this->parser, 'start_element', 'end_element');

                xml_set_character_dataHandler($this->parser, 'character_data');

                xml_set_defaultHandler($this->parser, 'defaultHandler');

                // Parse the XML file.

                if (!xml_parse($this->parser, $xml, true)) {
                    // Display an error message.

                    $this->debug(sprintf(
                        'XML error on line %d: %s',
                        xml_get_current_line_number($this->parser),
                        xml_error_string(xml_get_error_code($this->parser))
                    ));

                    $this->fault = true;
                } else {
                    // get final value

                    $this->soapresponse = $this->build_response($this->root_struct);
                }

                xml_parser_free($this->parser);
            } else {
                $this->debug("xml was empty, didn't parse!");
            }
        }

        // loop through msg, building response structures

        public function build_response($pos)
        {
            $response = null;

            if ('' != $this->message[$pos]['children']) {
                $this->debug('children string = ' . $this->message[$pos]['children']);

                $children = explode('|', $this->message[$pos]['children']);

                $this->debug('it has ' . count($children) . ' children');

                foreach ($children as $c => $child_pos) {
                    //$this->debug("child pos $child_pos: ".$this->message[$child_pos]["name"]);

                    if (null != $this->message[$child_pos]['type']) {
                        $this->debug('entering build_response() for ' . $this->message[$child_pos]['name'] . ", array pos $c, pos: $child_pos");

                        $response[] = $this->build_response($child_pos);
                    }
                }
            }

            // add current node's value

            if ($response) {
                $response = new soapval($this->message[$pos]['name'], $this->message[$pos]['type'], $response);
            } else {
                $this->debug('inside buildresponse: creating soapval ' . $this->message[$pos]['name'] . ' of type ' . $this->message[$pos]['type'] . ' and value: ' . $this->message[$pos]['cdata']);

                $response = new soapval($this->message[$pos]['name'], $this->message[$pos]['type'], $this->message[$pos]['cdata']);
            }

            return $response;
        }

        // start-element handler

        public function start_element($parser, $name, $attrs)
        {
            // position in a total number of elements, starting from 0

            // update class level pos

            $pos = $this->position++;

            // and set mine

            $this->message[$pos]['pos'] = $pos;

            // parent/child/depth determinations

            // depth = how many levels removed from root?

            // set mine as current global depth and increment global depth value

            $this->message[$pos]['depth'] = $this->depth++;

            // else add self as child to whoever the current parent is

            if (0 != $pos) {
                $this->message[$this->parent]['children'] .= "|$pos";
            }

            // set my parent

            $this->message[$pos]['parent'] = $this->parent;

            // set self as current value for this depth

            $this->depth_array[$this->depth] = $pos;

            // set self as current parent

            $this->parent = $pos;

            // set status

            if (preg_match(':Envelope$', $name)) {
                $this->status = 'envelope';
            } elseif (preg_match(':Header$', $name)) {
                $this->status = 'header';
            } elseif (preg_match(':Body$', $name)) {
                $this->status = 'body';

            // set method
            } elseif ('body' == $this->status) {
                $this->status = 'method';

                if (preg_match(':', $name)) {
                    $this->root_struct_name = mb_substr(mb_strrchr($name, ':'), 1);
                } else {
                    $this->root_struct_name = $name;
                }

                $this->root_struct = $pos;

                $this->message[$pos]['type'] = 'struct';
            }

            // set my status

            $this->message[$pos]['status'] = $this->status;

            // set name

            $this->message[$pos]['name'] = htmlspecialchars($name, ENT_QUOTES | ENT_HTML5);

            // set attrs

            $this->message[$pos]['attrs'] = $attrs;

            // get namespace

            if (preg_match(':', $name)) {
                $namespace = mb_substr($name, 0, mb_strpos($name, ':'));

                $this->message[$pos]['namespace'] = $namespace;

                $this->default_namespace = $namespace;
            } else {
                $this->message[$pos]['namespace'] = $this->default_namespace;
            }

            // loop through atts, logging ns and type declarations

            foreach ($attrs as $key => $value) {
                // if ns declarations, add to class level array of valid namespaces

                if (preg_match('xmlns:', $key)) {
                    $prefix = mb_substr(mb_strrchr($key, ':'), 1);

                    if ('xsd' == $prefix) {
                        global $XMLSchemaVersion,$namespaces;

                        $XMLSchemaVersion = $value;

                        $tmpNS = array_flip($namespaces);

                        $tmpNS['xsd'] = $XMLSchemaVersion;

                        $tmpNS['xsi'] = $XMLSchemaVersion . '-instance';

                        $namespaces = array_flip($tmpNS);
                    }

                    $this->namespaces[mb_substr(mb_strrchr($key, ':'), 1)] = $value;

                    // set method namespace

                    if ($name == $this->root_struct_name) {
                        $this->methodNamespace = $value;
                    }

                    // if it's a type declaration, set type
                } elseif ('xsi:type' == $key) {
                    $this->message[$pos]['type'] = mb_substr(mb_strrchr($value, ':'), 1);

                // should do something here with the namespace of specified type?
                } elseif ('SOAP-ENC:arrayType' == $key) {
                    $this->message[$pos]['type'] = 'array';
                }
            }
        }

        // end-element handler

        public function end_element($parser, $name)
        {
            // position of current element is equal to the last value left in depth_array for my depth

            $pos = $this->depth_array[$this->depth];

            // bring depth down a notch

            $this->depth--;

            // get type if not explicitly declared in an xsi:type attribute

            // man is this fucked up. can't do wsdl like dis!

            if ('' == $this->message[$pos]['type']) {
                if ('' != $this->message[$pos]['children']) {
                    $this->message[$pos]['type'] = 'SOAPStruct';
                } else {
                    $this->message[$pos]['type'] = 'string';
                }
            }

            // set eval str start if it has a valid type and is inside the method

            if ($pos >= $this->root_struct) {
                $this->message[$pos]['inval'] = 'true';
            }

            // if in the process of making a soap_val, close the parentheses and move on...

            if ('true' == $this->message[$pos]['inval']) {
                'false' == $this->message[$pos]['inval'];
            }

            // if tag we are currently closing is the method wrapper

            if ($pos == $this->root_struct) {
                $this->status = 'body';
            } elseif (preg_match(':Body', $name)) {
                $this->status = 'header';
            } elseif (preg_match(':Header', $name)) {
                $this->status = 'envelope';
            }

            // set parent back to my parent

            $this->parent = $this->message[$pos]['parent'];

            $this->debug("parsed $name end, type '" . $this->message[$pos]['type'] . "' children = " . $this->message[$pos]['children']);
        }

        // element content handler

        public function character_data($parser, $data)
        {
            $pos = $this->depth_array[$this->depth];

            $this->message[$pos]['cdata'] .= $data;
        }

        // default handler

        public function defaultHandler($parser, $data)
        {
            //$this->debug("DEFAULT HANDLER: $data");
        }

        // function to check fault status

        public function fault()
        {
            if ($this->fault) {
                return true;
            }

            return false;
        }

        // have this return a soap_val object

        public function get_response()
        {
            if ($this->soapresponse) {
                return $this->soapresponse;
            }

            $this->debug('ERROR: did not successfully eval the msg');

            $this->fault = true;

            return new soapval('Fault', 'struct', [new soapval('faultcode', 'string', 'SOAP-ENV:Server'), new soapval('faultstring', 'string', "couldn't build response")]);
        }

        public function debug($string)
        {
            if ($this->debug_flag) {
                $this->debug_str .= "soap_parser: $string\n";
            }
        }

        public function decode_entities($text)
        {
            foreach ($this->entities as $entity => $encoded) {
                $text = str_replace($encoded, $entity, $text);
            }

            return $text;
        }
    }

    /* soapx4 high level class

    usage:

    // instantiate client with server info
    $soapclient = new soapclient( string path [ ,boolean wsdl] );

    // call method, get results
    echo $soapclient->call( string methodname [ ,array parameters] );

    // bye bye client
    unset($soapclient);

    */

    class soapclient
    {
        public $fault;

        public $faultcode;

        public $faultstring;

        public $faultdetail;

        public function __construct($endpoint, $wsdl = false, $portName = false)
        {
            $this->debug_flag = false;

            $this->endpoint = $endpoint;

            $this->portName = false;

            // make values

            if ($wsdl) {
                $this->endpointType = 'wsdl';

                $this->wsdlFile = $this->endpoint;

                // instantiate wsdl class

                $this->wsdl = new wsdl($this->endpoint);

                if ($portName) {
                    $this->portName = $portName;
                }
            }
        }

        public function call($method, $params = [], $namespace = false, $soapAction = false)
        {
            if ('wsdl' == $this->endpointType) {
                // get portName

                if (!$this->portName) {
                    $this->portName = $this->wsdl->getPortName($method);
                }

                // get endpoint

                if (!$this->endpoint = $this->wsdl->getEndpoint($this->portName)) {
                    die("no port of name '$this->portName' in the wsdl at that location!");
                }

                $this->debug("endpoint: $this->endpoint");

                $this->debug("portName: $this->portName");

                // get operation data

                if ($opData = $this->wsdl->getOperationData($this->portName, $method)) {
                    $soapAction = $opData['soapAction'];

                    // set input params

                    $i = count($opData['input']['parts']) - 1;

                    foreach ($opData['input']['parts'] as $name => $type) {
                        if (isset($params[$name])) {
                            $nparams[$name] = $params[$name];
                        } else {
                            $nparams[$name] = $params[$i];
                        }
                    }

                    $params = $nparams;
                } else {
                    die("could not get operation info from wsdl for operation: $method<br>");
                }
            }

            $this->debug("soapAction: $soapAction");

            // get namespace

            if (!$namespace) {
                if ('wsdl' != $this->endpointType) {
                    //die("method call requires namespace if wsdl is not available!");
                } elseif (!$namespace = $this->wsdl->getNamespace($this->portName, $method)) {
                    //die("no namespace found in wsdl for operation: $method!");
                }
            }

            $this->debug("namespace: $namespace");

            // make message

            $soapmsg = new soapmsg($method, $params, $namespace);

            $this->debug(preg_replace("\n", '', '<xmp>' . $soapmsg->serialize() . '</xmp>'));

            // instantiate client

            $dbg = "calling server at '$this->endpoint'...";

            if ($soap_client = new soap_client($this->endpoint)) {
                if ($this->debug_flag) {
                    $soap_client->debug_flag = true;
                }

                $this->debug($dbg . 'instantiated client successfully');

                $this->debug("server: $soap_client->server<br>path: $soap_client->path<br>port: $soap_client->port");

                // send

                $dbg = "sending msg w/ soapaction '$soapAction'...";

                if ($return = $soap_client->send($soapmsg, $soapAction)) {
                    $this->debug($soap_client->debug_str);

                    $this->request = $soap_client->outgoing_payload;

                    $this->response = $soap_client->incoming_payload;

                    $this->debug($dbg . 'sent message successfully and got a(n) ' . gettype($return) . ' back');

                    // check for valid response

                    if ('soapval' == get_class($return)) {
                        // fault?

                        if (eregi('fault', $return->name)) {
                            $this->debug('got fault');

                            $this->fault = true;

                            $faultArray = $return->decode();

                            foreach ($faultArray as $k => $v) {
                                //print "$k = $v<br>";

                                if ('faultcode' == $k) {
                                    $this->faultcode = $v;
                                }

                                if ('faultstring' == $k) {
                                    $this->faultstring = $v;
                                }

                                if ('faultdetail' == $k) {
                                    $this->faultdetail = $v;
                                }

                                $this->debug("$k = $v<br>");
                            }

                            return false;
                        }

                        // decode to native php datatype

                        $returnArray = $return->decode();

                        // return array of return values

                        if (is_array($returnArray)) {
                            return array_shift($returnArray);
                            // why is decode only returning an array, instead of the actual return vals?
                        }

                        $this->debug("didn't get array back from decode() for $return->name");

                        return false;
                    }

                    $this->debug("didn't get soapval object back from client");

                    return false;
                }

                $this->debug('client send/recieve error');

                return false;
            }

            $this->debug('unable to instantiate client object');

            return false;
        }

        public function debug($string)
        {
            if ($this->debug_flag) {
                $this->debug_data .= "soapclient: $string\n";
            }
        }
    }

    /*

    this is a class that loads a wsdl file and makes it's data available to an application
    it should provide methods that allow both client and server usage of it

    also should have methods for creating a wsdl file from scratch and
    serializing wsdl into valid markup

    */

    class wsdl
    {
        // constructor

        public function __construct($wsdl = false)
        {
            // define internal arrays of bindings, ports, operations, messages, etc.

            $this->complexTypes = [];

            $this->messages = [];

            $this->currentMessage;

            $this->currentOperation;

            $this->portTypes = [];

            $this->currentPortType;

            $this->bindings = [];

            $this->currentBinding;

            $this->ports = [];

            $this->currentPort;

            // debug switch

            $this->debug_flag = false;

            // parser vars

            $this->parser;

            $this->position;

            $this->depth;

            $this->depth_array = [];

            // Check whether content has been read.

            if ($wsdl) {
                $wsdl_string = implode('', file($wsdl));

                // Create an XML parser.

                $this->parser = xml_parser_create();

                // Set the options for parsing the XML data.

                //xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);

                xml_parser_set_option($this->parser, XML_OPTION_CASE_FOLDING, 0);

                // Set the object for the parser.

                xml_set_object($this->parser, $this);

                // Set the element handlers for the parser.

                xml_set_elementHandler($this->parser, 'start_element', 'end_element');

                xml_set_character_dataHandler($this->parser, 'character_data');

                //xml_set_defaultHandler($this->parser, "defaultHandler");

                // Parse the XML file.

                if (!xml_parse($this->parser, $wsdl_string, true)) {
                    // Display an error message.

                    $this->debug(sprintf(
                        'XML error on line %d: %s',
                        xml_get_current_line_number($this->parser),
                        xml_error_string(xml_get_error_code($this->parser))
                    ));

                    $this->fault = true;
                }

                xml_parser_free($this->parser);
            }
        }

        // start-element handler

        public function start_element($parser, $name, $attrs)
        {
            // position in the total number of elements, starting from 0

            $pos = $this->position++;

            $depth = $this->depth++;

            // set self as current value for this depth

            $this->depth_array[$depth] = $pos;

            // find status, register data

            switch ($this->status) {
            case 'types':
                switch ($name) {
                    case 'schema':
                    $this->schema = true;
                    break;
                    case 'complexType':
                        $this->currentElement = $attrs['name'];
                        $this->schemaStatus = 'complexType';
                    break;
                    case 'element':
                        $this->complexTypes[$this->currentElement]['elements'][$attrs['name']] = $attrs;
                    break;
                    case 'complexContent':

                    break;
                    case 'restriction':
                        $this->complexTypes[$this->currentElement]['restrictionBase'] = $attrs['base'];
                    break;
                    case 'sequence':
                        $this->complexTypes[$this->currentElement]['order'] = 'sequence';
                    break;
                    case 'all':
                        $this->complexTypes[$this->currentElement]['order'] = 'all';
                    break;
                    case 'attribute':
                        if ($attrs['ref']) {
                            $this->complexTypes[$this->currentElement]['attrs'][$attrs['ref']] = $attrs;
                        } elseif ($attrs['name']) {
                            $this->complexTypes[$this->currentElement]['attrs'][$attrs['name']] = $attrs;
                        }
                    break;
                }
            break;
            case 'message':
                if ('part' == $name) {
                    $this->messages[$this->currentMessage][$attrs['name']] = $attrs['type'];
                }
            break;
            case 'portType':
                switch ($name) {
                    case 'operation':
                        $this->currentOperation = $attrs['name'];
                        $this->portTypes[$this->currentPortType][$attrs['name']]['parameterOrder'] = $attrs['parameterOrder'];
                    break;
                    default:
                        $this->portTypes[$this->currentPortType][$this->currentOperation][$name] = $attrs;
                    break;
                }
            break;
            case 'binding':
                switch ($name) {
                    case 'soap:binding':
                        $this->bindings[$this->currentBinding] = array_merge($this->bindings[$this->currentBinding], $attrs);
                    break;
                    case 'operation':
                        $this->currentOperation = $attrs['name'];
                        $this->bindings[$this->currentBinding]['operations'][$attrs['name']] = [];
                    break;
                    case 'soap:operation':
                        $this->bindings[$this->currentBinding]['operations'][$this->currentOperation]['soapAction'] = $attrs['soapAction'];
                    break;
                    case 'input':
                        $this->opStatus = 'input';
                        // no break
                    case 'soap:body':
                        $this->bindings[$this->currentBinding]['operations'][$this->currentOperation][$this->opStatus] = $attrs;
                    break;
                    case 'output':
                        $this->opStatus = 'output';
                    break;
                }
            break;
            case 'service':
                switch ($name) {
                    case 'port':
                        $this->currentPort = $attrs['name'];
                        $this->ports[$attrs['name']] = $attrs;
                    break;
                    case 'soap:address':
                        $this->ports[$this->currentPort]['location'] = $attrs['location'];
                    break;
                }
            break;
        }

            // set status

            switch ($name) {
            case 'types':
                $this->status = 'types';
            break;
            case 'message':
                $this->status = 'message';
                $this->messages[$attrs['name']] = [];
                $this->currentMessage = $attrs['name'];
            break;
            case 'portType':
                $this->status = 'portType';
                $this->portTypes[$attrs['name']] = [];
                $this->currentPortType = $attrs['name'];
            break;
            case 'binding':
                $this->status = 'binding';
                $this->currentBinding = $attrs['name'];
                $this->bindings[$attrs['name']]['type'] = $attrs['type'];
            break;
            case 'service':
                $this->serviceName = $attrs['name'];
                $this->status = 'service';
            break;
            case 'definitions':
                foreach ($attrs as $name => $value) {
                    $this->wsdl_info[$name] = $value;
                }
            break;
        }

            // get element prefix

            if (preg_match(':', $name)) {
                $prefix = mb_substr($name, 0, mb_strpos($name, ':'));
            }
        }

        public function getEndpoint($portName)
        {
            if ($endpoint = $this->ports[$portName]['location']) {
                return $endpoint;
            }

            return false;
        }

        // find the name of the first port that contains an operation of name $operation

        public function getPortName($operation)
        {
            foreach ($this->ports as $port => $portAttrs) {
                $binding = mb_substr($portAttrs['binding'], 4);

                if ('' != $this->bindings[$binding]['operations'][$operation]) {
                    return $port;
                }
            }
        }

        public function getOperationData($portName, $operation)
        {
            if ($binding = mb_substr($this->ports[$portName]['binding'], 4)) {
                // get operation data from binding

                if (is_array($this->bindings[$binding]['operations'][$operation])) {
                    $opData = $this->bindings[$binding]['operations'][$operation];
                }

                // get operation data from porttype

                $portType = mb_substr(mb_strstr($this->bindings[$binding]['type'], ':'), 1);

                if (is_array($this->portTypes[$portType][$operation])) {
                    $opData['parameterOrder'] = $this->portTypes[$portType][$operation]['parameterOrder'];

                    $opData['input'] = array_merge($opData['input'], $this->portTypes[$portType][$operation]['input']);

                    $opData['output'] = array_merge($opData['output'], $this->portTypes[$portType][$operation]['output']);
                }

                // message data from messages

                $inputMsg = mb_substr(mb_strstr($opData['input']['message'], ':'), 1);

                $opData['input']['parts'] = $this->messages[$inputMsg];

                $outputMsg = mb_substr(mb_strstr($opData['output']['message'], ':'), 1);

                $opData['output']['parts'] = $this->messages[$outputMsg];
            }

            return $opData;
        }

        public function getSoapAction($portName, $operation)
        {
            if ($binding = mb_substr($this->ports[$portName]['binding'], 4)) {
                if ($soapAction = $this->bindings[$binding]['operations'][$operation]['soapAction']) {
                    return $soapAction;
                }

                return false;
            }

            return false;
        }

        public function getNamespace($portName, $operation)
        {
            if ($binding = mb_substr($this->ports[$portName]['binding'], 4)) {
                //$this->debug("looking for namespace using binding '$binding', port '$portName', operation '$operation'");

                if ($namespace = $this->bindings[$binding]['operations'][$operation]['input']['namespace']) {
                    return $namespace;
                }

                return false;
            }

            return false;
        }

        // end-element handler

        public function end_element($parser, $name)
        {
            // position of current element is equal to the last value left in depth_array for my depth

            $pos = $this->depth_array[$this->depth];

            // bring depth down a notch

            $this->depth--;
        }

        // element content handler

        public function character_data($parser, $data)
        {
            $pos = $this->depth_array[$this->depth];

            $this->message[$pos]['cdata'] .= $data;
        }

        public function debug($string)
        {
            if ($this->debug_flag) {
                $this->debug_str .= "wsdl: $string\n";
            }
        }
    }

    // xsd:dateTime helpers

    function timestamp_to_iso8601($timestamp)
    {
        $datestr = date("Y-m-d\TH:i:sO", $timestamp);

        /* normalize to UTC
        $tz = substr($datestr,strlen($datestr)-5,5);
        $op = substr($tz,0,1);
        $h = substr($tz,1,2);
        $m = substr($tz,3,2);
        if($op == "-"){
        	$regs[4] = $regs[4] - $h;
        	$regs[5] = $regs[5] - $m;
        } elseif($op == "+"){
        	$regs[4] = $regs[4] + $h;
        	$regs[5] = $regs[5] + $m;
        }
        */

        return $datestr;
    }

    function iso8601_to_timestamp($datestr)
    {
        $eregStr = '([0-9]{4})-' .	// centuries & years CCYY-
    '([0-9]{2})-' .	// months MM-
    '([0-9]{2})' .	// days DD
    'T' .			// separator T
    '([0-9]{2}):' .	// hours hh:
    '([0-9]{2}):' .	// minutes mm:
    "([0-9]{2})(\.[0-9]*)?" . // seconds ss.ss...
    "(Z|[+\-][0-9]{4})"; // Z to indicate UTC, -/+HH:MM:SS.SS... for local tz's
    if (preg_match($eregStr, $datestr, $regs)) {
        if ('Z' != $regs[8]) {
            $op = mb_substr($regs[8], 0, 1);

            $h = mb_substr($regs[8], 1, 2);

            $m = mb_substr($regs[8], 3, 2);

            if ('-' == $op) {
                $regs[4] -= $h;

                $regs[5] -= $m;
            } elseif ('+' == $op) {
                $regs[4] += $h;

                $regs[5] += $m;
            }
        }

        return strtotime("$regs[1]-$regs[2]-$regs[3] $regs[4]:$regs[5]:$regs[6]Z");
    }

        return false;
    }

    class GoogleApiSearch
    {
        public $google_registration_key = 'v0P7Z/tQFHJMNVsiycwykD9WXu/b3BB4';

        public function doGoogleSearch($search, $start)
        {
            $soapDebug = false;

            $maxResults = (int)10;

            if ($soapDebug) {
                echo '<p>Begin SOAP:<p>';
            }

            $query = [];

            $query['key'] = $this->google_registration_key;

            if ($soapDebug) {
                echo 'Google Registration Key: ' . $query['key'] . '<br>';
            }

            $query['q'] = $search;

            $query['start'] = (int)$start;

            $query['maxResults'] = $maxResults;

            $query['filter'] = (bool)true;

            $query['restrict'] = '';

            $query['safeSearch'] = (bool)false;

            $query['lr'] = '';

            $query['ie'] = 'latin1';

            $query['oe'] = 'latin1';

            $soapclient = new soapclient('http://api.google.com/search/beta2');

            if ($soapDebug) {
                $soapclient->debug_flag = true;
            }

            $google_results = $soapclient->call('doGoogleSearch', $query, 'urn:GoogleSearch', 'doGoogleSearch');

            if ($soapDebug) {
                echo nl2br($soapclient->debug_data);

                echo '<HR>Result: <br>';

                $this->renderArray($google_results, 'google_results');

                echo '<HR>';

                echo '<p>End SOAP<p>';
            }

            // Begin Generating the Google Results

            if (is_array($google_results)) {
                // The return value

                $outArray = [];

                // The raw google array

                $outArray['array'] = $google_results;

                // The "more" value - true or false depending on

                // if there are more results.

                $outArray['more'] = 0;

                $end = count($google_results['resultElements']);

                if ($end == $maxResults) {
                    $outArray['more'] = 1;
                }

                // The html of the google results - default rendering.
            } else {
                $outArray = false;
            }

            /////////////////////////////////////////////////////////////////////

            return $outArray;
        }

        // fn doGoogleSearch

        // This function is only used for debugging purposes.

        // A tool for displaying multi dimensional arrays.

        // I found this really helped understand the results returned by Google's SOAP API

        public function renderArray($arr, $name)
        {
            if (is_array($arr)) {
                $keys = array_keys($arr);

                $end = count($keys);

                for ($loop = 0; $loop < $end; $loop++) {
                    if (is_array($arr[$keys[$loop]])) {
                        $this->renderArray($arr[$keys[$loop]], $name . '[' . $keys[$loop] . ']');
                    } else {
                        echo $name . '[' . $keys[$loop] . ']' . ' = ' . $arr[$keys[$loop]] . '<br>';
                    }
                }
            } else {
                echo "$name is not an array<br>";
            }
        }
    }

    global $query_start;

    if (!isset($query_start)) {
        $query_start = 0;
    }

    $google_output = 0;

    $googleApiSearch = new GoogleApiSearch();

    $google_output = $googleApiSearch->doGoogleSearch($query, $query_start);

    // Generate the "more results" links at the bottom of the page.

    $numberOfNextLinks = $google_output['array']['estimatedTotalResultsCount'];

    echo '<table width="200" border="0" align="center" cellpadding="3" cellspacing="3">
  <tr> 
    <td width="100"><div align="right"><u><strong>' . _ENGINE . ':</strong></u></div></td>
    <td width="100"><div align="right"><u><strong>' . _BACKLINKS . ":</strong></u></div></td>
  </tr>
  <tr> 
    <td><div align=\"right\">Google:</div></td>
    <td><div align=\"right\">$numberOfNextLinks</div></td>
  </tr>
  <tr> 
    <td><div align=\"right\">AlltheWeb:</div></td>
    <td><div align=\"right\">$alltheweb</div></td>
  </tr>
  <tr> 
    <td><div align=\"right\">AltaVista:</div></td>
    <td><div align=\"right\">$altavista</div></td>
  </tr>
  <tr> 
    <td><div align=\"right\">AOL:</div></td>
    <td><div align=\"right\">$aol</div></td>
  </tr>
  <tr> 
    <td><div align=\"right\">MSN:</div></td>
    <td><div align=\"right\">$msn</div></td>
  </tr>
  <tr> 
    <td><div align=\"right\">HotBot:</div></td>
    <td><div align=\"right\">$hotbot</div></td>
  </tr>
  <tr> 
    <td><div align=\"right\">Lycos:</div></td>
    <td><div align=\"right\">$lycos</div></td>
  </tr>
</table>";
}

// copyright link ! don't remove it ! display only on non-members !
if (!isset($user)) {
    echo '<p align="right">' . ucfirst(_BY) . ' <a href="http://www.creation-de-site-brest.com" target="_blank">Création de site</a></right>';
}

CloseTable();
require XOOPS_ROOT_PATH . '/footer.php';
?>
