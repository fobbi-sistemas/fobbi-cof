Array.prototype.includes = function (val) {
    return this.indexOf(val) !== -1;
}
String.prototype.characterize = function (callback) {
    var characters = this.split('');
    var options = {};
    for (var i = 0; i < this.length; i++) {
        options = callback(characters[i]);
    }
}
var $keywordsC1 = ['this', 'super', 'arguments', 'error'];
var $keywordsC2 = ['class', 'extends', 'if', 'else', 'switch', 'case', 'break', 'default', 'for', 'of', 'continue', 'do', 'while', 'try', 'catch', 'finally', 'new', 'instanceof', 'typeof', 'export', 'import', 'delete', 'throw', 'in', 'with', 'print'];
var $keywordsC3 = ['const', 'var', 'let'];
var $keywordsC4 = ['null', 'true', 'false', 'undefined', 'NaN', 'Infinity'];
var $keywordsC5 = ['function', 'return', 'constructor', 'get', 'set'];
var $classes = ['Object', 'String', 'Number', 'Function', 'RegExp', 'Date', 'Boolean', 'Math', 'Array', 'Set', 'Map', 'Error', 'InternalError', 'RangeError', 'ReferenceError', 'SyntaxError', 'TypeError'];
var $keywords = [{
    refcss: 'keywordc1',
    words: $keywordsC1
}, {
    refcss: 'keywordc2',
    words: $keywordsC2
}, {
    refcss: 'keywordc3',
    words: $keywordsC3
}, {
    refcss: 'keywordc4',
    words: $keywordsC4
}, {
    refcss: 'keywordc5',
    words: $keywordsC5
}, {
    refcss: 'preclass',
    words: $classes
}];
var $textarea = document.getElementById('textarea-input');
var $highlight = document.getElementById('highlight-area');
var $run = document.getElementById('run');
var $download = document.getElementById('download');
var $suggestionslist = document.getElementById('ul-suggester');
var $suggestioncontainer = document.getElementById('div-suggester');
var $output = document.getElementById('output-list');
window.addEventListener('load', function () {
    $textarea.addEventListener('input', triggerHighlight);
    $textarea.addEventListener('scroll', function (event) {
        $highlight.scrollTop = this.scrollTop;
    });
    $textarea.addEventListener('keydown', function (event) {
        var tab = 9,
            enter = 13,
            space = 32,
            up = 38,
            down = 40,
            left = 37,
            right = 39,
            comillasimple = 219,
            comilladobles = 50,
            parentesis = 56,
            llaves = 222,
            corchetes = 222,
            d = 68,
            e = 69; //ejecutar
        if ($suggestioncontainer.style.display != 'none') {
            switch (event.keyCode) {
                case left:
                case right:
                case tab:
                    event.preventDefault();
                    break;
                case down:
                    event.preventDefault();
                    var posActive;
                    var arrayul = $suggestionslist.children;
                    for (var i = 0; i < arrayul.length; i++) {
                        if (arrayul[i].className == 'active-li') {
                            if (i != arrayul.length - 1) posActive = i + 1;
                            else posActive = 0;
                        }
                        arrayul[i].className = '';
                    }
                    $suggestionslist.children[posActive].className = 'active-li';
                    break;
                case up:
                    event.preventDefault();
                    var posActive;
                    var arrayul = $suggestionslist.children;
                    for (var i = 0; i < arrayul.length; i++) {
                        if (arrayul[i].className == 'active-li') {
                            if (i != 0) posActive = i - 1;
                            else posActive = arrayul.length - 1;
                        }
                        arrayul[i].className = '';
                    }
                    $suggestionslist.children[posActive].className = 'active-li';
                    break;
                case enter:
                    event.preventDefault();
                    $suggestioncontainer.style.display = 'none';
                    for (var i = 0; i < $suggestionslist.children.length; i++) {
                        if ($suggestionslist.children[i].className == 'active-li') {
                            insert($suggestionslist.children[i].children[0].innerText);
                            triggerHighlight();
                            break;
                        }
                    }
                    break;
                    /*case tab:
                        event.preventDefault();
                        var sni = tokenize($highlight.children[0].children[getLine() - 1].innerText.substr(0, getColumn()).split(/(\s)+/).pop())[0];
                        if (sni && sni.type == 'default') {
                            if (sni.value == 'fun') insert("ction f(){}");
                            if (sni.value == 'cla') insert("ss c {}");
                            if (sni.value == 'swi') insert("tch(){case :break;default:}");
                        }
                        $suggestioncontainer.style.display = 'none';
                        triggerHighlight();
                        break;*/
            }
        } else {
            switch (event.keyCode) {
                case tab:
                    event.preventDefault();
                    insert('    ');
                    triggerHighlight();
                    break;
                case comillasimple:
                    if (!event.shiftKey) {
                        event.preventDefault();
                        insert('\'\'');
                        triggerHighlight();
                    }
                    break;
                case llaves:
                    if (!event.shiftKey) {
                        event.preventDefault();
                        insert('{}');
                        triggerHighlight();
                    }
                    break;
            }
            if (event.shiftKey && event.keyCode == comilladobles) {
                event.preventDefault();
                insert('""');
                triggerHighlight();
            }
            if (event.shiftKey && event.keyCode == parentesis) {
                event.preventDefault();
                insert('()');
                triggerHighlight();
            }
            if (event.shiftKey && event.keyCode == corchetes) {
                event.preventDefault();
                insert('[]');
                triggerHighlight();
            }
            if (event.ctrlKey && event.keyCode == e) {
                event.preventDefault();
                $run.click();
            }
            if (event.ctrlKey && event.keyCode == d) {
                event.preventDefault();
                $download.click();
            }
            if (event.ctrlKey && event.keyCode == space) {
                event.preventDefault();
                autosuggester(tokenize($highlight.children[0].children[getLine() - 1].innerText.substr(0, getColumn()).split(/(\s)+/).pop())[0]);
            }
        }
    });
    $suggestionslist.addEventListener("mouseover", function () {
        for (var i = 0; i < this.children.length; i++) this.children[i].className = '';
    });
    $suggestionslist.addEventListener("mouseout", function () {
        if (this.children[0]) {
            this.children[0].className = 'active-li';
            $textarea.focus();
        }
    });
    triggerHighlight();
});
var triggerHighlight = function(){
var tokens = tokenize($textarea.value);
if (tokens.length == 0) $highlight.innerHTML = '<ol class="linenums"><li></li></ol>';
else {
    var aux = '<ol class="linenums"><li>';
    tokens.forEach(function (token, index, array) {
        aux += '<span class="highlight-' + token.type + '">' + ((token.type == 'newline') ? '<br>' : token.value) + '</span>';
        autosuggester(token);
        if (token.type == 'newline') aux += '</li><li>';
        if (index == array.length - 1) aux += '</li></ol>';
    });
    $highlight.innerHTML = aux;
}

};

function tokenize(inputString) {
    var tokens = [];
    var lexedValue = '';
    var currentToken = null;

    function newSpaceToken() {
        currentToken = {
            type: 'space',
            value: ' '
        };
        lexedValue = '';
    }

    function parseLexedValueToToken() {
        if (lexedValue) {
            $keywords.forEach(function (elem) {
                if (elem.words.includes(lexedValue)) {
                    tokens.push({
                        type: elem.refcss,
                        value: lexedValue
                    });
                    lexedValue = '';
                    return;
                }
            });
            if (lexedValue !== '') {
                if (isNaN(lexedValue)) {
                    tokens.push({
                        type: 'default',
                        value: lexedValue
                    });
                } else {
                    tokens.push({
                        type: 'number',
                        value: lexedValue
                    });
                }
            }
            lexedValue = '';
        }
    }

    function lex(char) {
        if (char !== ' ' && currentToken && currentToken.type === 'space') {
            tokens.push(currentToken);
            lexedValue = '';
            currentToken = null;
        }
        switch (char) {
            case ' ':
                if ($keywordsC1.includes(lexedValue)) {
                    tokens.push({
                        type: 'keywordc1',
                        value: lexedValue
                    });
                    newSpaceToken();
                } else if ($keywordsC2.includes(lexedValue)) {
                    tokens.push({
                        type: 'keywordc2',
                        value: lexedValue
                    });
                    newSpaceToken();
                } else if ($keywordsC3.includes(lexedValue)) {
                    tokens.push({
                        type: 'keywordc3',
                        value: lexedValue
                    });
                    newSpaceToken();
                } else if ($keywordsC4.includes(lexedValue)) {
                    tokens.push({
                        type: 'keywordc4',
                        value: lexedValue
                    });
                    newSpaceToken();
                } else if ($keywordsC5.includes(lexedValue)) {
                    tokens.push({
                        type: 'keywordc5',
                        value: lexedValue
                    });
                    newSpaceToken();
                } else if ($classes.includes(lexedValue)) {
                    tokens.push({
                        type: 'preclass',
                        value: lexedValue
                    });
                    newSpaceToken();
                } else if (lexedValue !== '') {
                    if (isNaN(lexedValue)) {
                        tokens.push({
                            type: 'default',
                            value: lexedValue
                        });
                    } else {
                        tokens.push({
                            type: 'number',
                            value: lexedValue
                        });
                    }
                    newSpaceToken();
                } else if (currentToken) {
                    currentToken.value += ' '
                } else {
                    newSpaceToken();
                }
                break;
            case '"':
            case '\'':
                if (currentToken) {
                    if (currentToken.type === 'string') {
                        if (currentToken.value[0] === char) {
                            currentToken.value += char
                            tokens.push(currentToken)
                            currentToken = null;
                        } else {
                            currentToken.value += char
                        }
                    } else if (currentToken.type === 'comment') {
                        currentToken.value += char
                    }
                } else {
                    if (lexedValue) {
                        tokens.push({
                            type: 'default',
                            value: lexedValue
                        });
                        lexedValue = '';
                    }
                    currentToken = {
                        type: 'string',
                        value: char
                    };
                }
                break;
            case '=':
            case '+':
            case '-':
            case '*':
            case '/':
            case '%':
            case '&':
            case '|':
            case '>':
            case '<':
            case '!':
            case '?':
            case ':':
                if (currentToken) {
                    currentToken.value += char;
                } else {
                    parseLexedValueToToken();
                    tokens.push({
                        type: 'operator',
                        value: char
                    });
                }
                break;
            case '(':
                if (currentToken) {
                    currentToken.value += char;
                } else {
                    parseLexedValueToToken();
                    tokens.push({
                        type: 'left-parentheses',
                        value: char
                    });
                }
                break;
            case ')':
                if (currentToken) {
                    currentToken.value += char;
                } else {
                    parseLexedValueToToken();
                    tokens.push({
                        type: 'right-parentheses',
                        value: char
                    });
                }
                break;
            case '{':
            case '}':
            case '[':
            case ']':
            case ',':
            case ';':
            case '.':
                if (currentToken) {
                    currentToken.value += char;
                } else {
                    parseLexedValueToToken();
                    tokens.push({
                        type: 'delimiter',
                        value: char
                    });
                }
                break;
            case '\n':
                if (currentToken) {
                    if (currentToken.type == 'string' || currentToken.type == 'comment') {
                        tokens.push(currentToken)
                        currentToken = null;
                    }
                } else {
                    parseLexedValueToToken();
                    lexedValue = '';
                }
                tokens.push({
                    type: 'newline',
                    value: '\n'
                });
                break;
            default:
                if (currentToken) currentToken.value += char;
                else lexedValue += char;
                break;
        }
    }
    inputString.characterize(lex);
    parseLexedValueToToken();
    if (currentToken) tokens.push(currentToken);
    var isFunctionArgumentScope = false;
    var isCommentLine = false,
        isCommentMultiLine = false;
    for (var i = 0; i < tokens.length; i++) {
        var token = tokens[i];
        if (token.value == '/' && tokens[i - 1] && tokens[i - 1].value == '/') {
            isCommentLine = true;
            tokens[i - 1].type = 'comment';
            tokens[i].type = 'comment';
        } else if (token.value == '*' && tokens[i - 1] && tokens[i - 1].value == '/') {
            isCommentMultiLine = true;
            tokens[i - 1].type = 'comment';
            tokens[i].type = 'comment';
        } else if (token.type == 'newline' && isCommentLine) {
            isCommentLine = false;
        } else if (token.value == '/' && tokens[i - 1] && tokens[i - 1].value == '*' && isCommentMultiLine) {
            tokens[i].type = 'comment';
            isCommentMultiLine = false;
        } else if (isCommentLine || isCommentMultiLine) {
            tokens[i].type = 'comment';
        } else if (token.type == 'left-parentheses') {
            if (tokens[i - 1] && tokens[i - 1].type == 'default') {
                tokens[i - 1].type = 'function-name';
                isFunctionArgumentScope = true;
            } else if (tokens[i - 1] && tokens[i - 1].value == 'function' || tokens[i - 1].value == 'constructor' || tokens[i - 1].value == 'super') isFunctionArgumentScope = true;
        } else if (token.type == 'default' && isFunctionArgumentScope) {
            token.type = 'argument';
        } else if (token.type == 'right-parentheses') {
            isFunctionArgumentScope = false;
        } else if (token.type == 'default' && ((tokens[i - 6] && tokens[i - 6].value == 'this') || (tokens[i - 5] && tokens[i - 5].value == 'this') || (tokens[i - 4] && tokens[i - 4].value == 'this'))) {
            token.type = 'argument';
        }
    }
    return tokens
}

function autosuggester(token) {
    if (token.type == 'default' || token.type == 'argument') {
        $suggestionslist.innerHTML = '';
        var $bloques = ["function f(){\n    \n}", "var f = function(){\n    \n};", "class c {\n    \n}", "var c = class{\n    \n};", "if(true){\n    \n}", "else if(true){\n    \n}", "switch(0){\n    \n}", "case 0:\n    \n        break;", "default:", "for(var i=0; i<10; i++){\n    \n}", "for(var i of [0]){\n    \n}", "for(var i in {a: 0}){\n    \n}", "forEach(function(elem, ind, arr){\n    \n});", "while(true){\n    \n}", "do{\n    \n}while(cierto);", "try{\n    \n}catch(error){\n    \n}finally{\n    \n}"];
        var suggestions = new Set($keywordsC1.concat($keywordsC2, $keywordsC3, $keywordsC4, $keywordsC5, $classes, $bloques, getUserWords()).sort());
        suggestions.forEach(function (elem) {
            if (elem.substr(0, token.value.length) == token.value && elem.length > token.value.length) {
                var li = document.createElement('li');
                var b = document.createElement('b');
                var aux = '<div style="display:none;">' + elem.substr(token.value.length) + '</div>';
                tokenize(elem).forEach(function (token) {
                    aux += '<span class="highlight-' + token.type + '">' + token.value + '</span>';
                });
                li.innerHTML = aux;
                li.addEventListener("click", function () {
                    $suggestioncontainer.style.display = 'none';
                    insert(this.children[0].innerText);
                    triggerHighlight();
                });
                $suggestionslist.appendChild(li);
            }
        });
        if ($suggestionslist.children.length > 0) {
            $suggestioncontainer.style.display = '';
            $suggestioncontainer.style.top = 10 + (getLine() * 14) + 'px';
            $suggestioncontainer.style.left = 50 + (getColumn() * 7) + 'px';
            $suggestionslist.children[0].className = 'active-li';
        } else $suggestioncontainer.style.display = 'none';
    } else $suggestioncontainer.style.display = 'none';

    function getUserWords() {
        var arr = [];
        var code = $textarea.value.split('');
        var word = '';
        var iscomm = false;
        code.forEach(function (val) {
            if (/[a-zA-Z]/.test(val)) {
                word += val;
            } else {
                if (word != '') {
                    arr.push(word);
                    word = '';
                }
            }
        });
        return arr;
    }
}

function getLine() {
    return $textarea.value.substr(0, $textarea.selectionStart).split("\n").length;
}

function getColumn() {
    var pos = $textarea.selectionStart;
    var numChars = 0;
    var lineArr = $textarea.value.substr(0, pos).split("\n");
    for (var i = 0; i < lineArr.length - 1; i++) numChars += lineArr[i].length + 1;
    return pos - numChars;
}

function insert(char) {
    var v = $textarea.value,
        s = $textarea.selectionStart,
        e = $textarea.selectionEnd;
    $textarea.value = v.substring(0, s) + char + v.substring(e);
    $textarea.selectionStart = $textarea.selectionEnd = s + ((/[\w ]/.test(char)) ? char.length : 1);
}