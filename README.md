# Rumble Text

Rumbletext is a simple PHP library for generating random text.

My intent was to make a library suitable for generating placeholder (lorem ipsum) text. It uses a primitive algorithm for making pronouncable words. It comes with some various lettersets for use in probabilities of vowel and consonant distribution to assist in this.

## Installation

To install, use composer with the following command:

```
composer require sumpygump/rumble-text
```

## Usage

### As a library

The primary usage of this library is to use it as a service in a PHP project. Instantiate an instance of the class `RumbleText` and call the various functions like `generateRandomWord()`. This will return an random generated word.

Example:

```
<?php
require_once 'vendor/autoload.php';

use RumbleText\RumbleText;

$rumble = new RumbleText(RumbleText::LETTERSET_ORIGINAL);
$word = $rumble->generateRandomWord();
echo $word . "\n";
```

List of available methods:

* generateRandomString($length, $chars)
* generateRandomPhrase($min = 1, $max = 5, $as_array = false)
* generateRandomSentence($min = 1, $max = 20, $as_array = false)
* generateRandomParagraph($min = 1, $max = 20, $exact_wordcount = null, $as_array = false)
* generateRandomArticle($min = 1, $max = 8, $exact_wordcount = null)
* generateRandomWord($length = 5, $lower_case = true, $ucfirst = false, $upper_case = false, $exactlength = false)
* generateRandomName($maxlength = 10)
* generateRandomCompany($maxwords = 2)
* generateRandomWebsite()
* generateRandomEmail()
* generateRandomDigits($minlength = 4, $maxlength = 16, $exactlength = 0)
* generateRandomPhone()
* generateRandomAddress()

### As a CLI script

There is also a cli script that can be used to output various random strings from the command line.

Use `rumble-text --help` to get the following help message:

```
Rumble-text generates random text.

Usage: rumble-text [--letterset <letterset>] [--type <type>] [--chars <chars>] [wordcount|length]
  --letterset allows to select algorithm for probabilities of vowels and
              consonants to use
  --type allows to pick what type of entity to produce (whether string, word,
         name, paragraph, etc.)
  --chars is only used for type 'string', the format is a string of chars to
          pick from. e.g. --chars abcdef012
  some types use wordcount to output a certain number of words, and some types
  use length to specify character length

Valid lettersets:
 - original
 - equal
 - baba
 - caesar
 - hayden
 - parseltongue

Valid types:
 - string
 - phrase
 - sentence
 - paragraph
 - article
 - word
 - name
 - company
 - website
 - email
 - digits
 - phone
 - address
```

## Lettersets

Below is a showcase of the lettersets available. Note: the lettersets are not used for the methods `generateRandomString` or `generateRandomDigits`

### Original

The original letterset has a straightforward distribution of vowels and consonants. I fine-tuned it manually based on what I thought was aesthetically pleasing.

```
Cojo pamfyresi petyop irwydaw, buspe pib hyto my satwotar! Tesasraf etydna
ahlesfome syvitvada mainvirrus er wor savmy paszote enmys cezaat cerrace
sa. Ohsepa sarba sit otsel vijizupe esnevremiro nidsol dovsi acis sedoltuz
yz tekecna hekeco pap hovabator. Botsibe osbapal vejeen syceirme tobhyt
astymak jefmesa soesmar dacov sonfif idsuznewe emsoc peb peumedav renodan.
Cim, ysgul. Enarutro eg abjis tabetatet tynyjjas nawhe et bemonot ergahe,
do?.
```

### Caesar

The caesar letterset is based on the distribution of english word letters as described in the manpage of `caesar`:

> The frequency (from most common to least) of English letters is as follows:
> ETAONRISHDLFCMUGPYWBVKXJQZ
> Their frequencies as a percentage are as follows:
> E(13),  T(10.5),  A(8.1),  O(7.9),  N(7.1),  R(6.8),  I(6.3), S(6.1), H(5.2), D(3.8), L(3.4), F(2.9), C(2.7), M(2.5), U(2.4), G(2), P(1.9), Y(1.9), W(1.5), B(1.4), V(.9), K(.4), X(.15), J(.13), Q(.11), Z(.07).

This letterset produces text like this:

```
"Ter?" Awaf wile! Nelen ninfena turoab peti diced om pafatite opleh,
lagcomuni mepetometa tofegod. Et itad tis onurrateh ittejad he ananmeron
coesenni. Sarororih ostonet lyntav it oprir rela dekyro feid boerhe lansan
pewym sedisibe hosi runreh dolarmer itcihheg idunab. Noctona otruhe
nuenteci darerut nis dohsu meorensin lostonpes as socuis mofotlec nebon
dotag mense noy ef sito gifdeosel tan id. Teveta votiad ubsesmog gehmi
gomef? Gel eshes rerarog ew pocivis lomtadsece tonasofi arho. Temehe
wesanouf etder egopet. Kace fera oqon astesi sonefeh he atcuawhon eh tele
rose hofad tosoyat neamos famu selepa odit tatrid tetemlos dorodot. Ris ta
ren efareltis bessihes.
```

### Hayden

In my search for even better approximation of human words I found a paper by Rebecca Hayden where she described the various phonemes and their distribution in speech. I used the results of her paper to generate the hayden letterset.

Here is an example of hayden:

```
Ralawa it rofnayidiy rasnal nis thati ri taszalon ethfymu. Harzanne. Imzin
nadatura nisgenbomi favatazare pezetot iltatpas tiis hakimele amlasias
lyfus neinus tiziam derech yachi sat attathis afkaizev kihir thayefeth.
Reslika niglad tirostasu sital raregshuna tuzaalfar zari sir dalneal pidfiz
shatteti re, imnonara kir inmajapdi kat iswamekzi?

Danekitava lewit thachar. Ta natiwh vinan nay littera toim. Ang taatarla
mulalanik tialcheth isyah turthazah atnat valka apre sifthas yrvil yoyain?
Kashin nakef panni arif kav, rit ihavny lulkan al totu jayg fililin thyna ihta
imaj natna jeargi? Zaimnap na whemusha kur er ngata, vewfe anam. Azhthat arjeh
ilnaiwh hanema anasenry azilyng.
```

### Equal

The equal letterset has a equal probability for selecting every letter in the alphabet. Unlike the previous examples, there is no weighting for certain letters, so you end up with more j, z, x, w and other rare letters.

```
Tadon owdocon picevo pumozupdiz rova ev rotpis tavaqag man ihpiminu
kemliwal? Oknit tofbihrela atifuy liokqat nojjoj. Subi ilmof diig yeuc
sayibuet tafiq xisayu xoja ek ozir juiy yelpeza boleso higohabe yoduzif.
Oloxroki coeskovo uszeaf got birfus cerpe seuj quaqufpu ejqemcup jaskel
nufo ipmuet xeaw ezde. Ji yutzilewa onjizueg gemikfoh atmahih. Webe bavi
unur qivo embamo fucixu dawa monus lip ifziquhka, wasov cogiew ucnoorced
yiol kiclaz ewjag sol? Kopefit viyojecoy tipiollir kez jezih. Omqaru ulgiru
ful lu jow jak wowquga faqweiwdab, enve cucfapi nuga binevuj qahkixi pez
tec sim? Gokeg xuowjinzez vuscujah qayaiy. Jeej huranilib cakufas mofcato
niondupis wohu sobkimo acfufhofu.
```

### Baba

The 'baba' letterset is just for fun. It will pick a random vowel and a random consonant and ONLY use those in generating words.

Example output. In this example, it picked 'x' and 'i':

```
Xixxixxix ixxi xixix xixxixix ixxixi xix.

Ixxixix xixixi ixixxixix ix xixixxixi xixixixxix ixxixxix ixxixxiix
xiixxixi xixixixxi xixixixi xixix ix xix ixxiixix xixixxix xix xixiixxi
xixxi xixxixi. Ixxixix "xiixix?" Xi ixxixxi. Xixix xixxixxixi xix
ixxixxixix ix ixixxixi xiix ix ixxiixxix ixixxixi xixxixi xixxixi xixxi
xixix xiix xi. Ixixxixix xixxix xixixix xiixixxix xixixixi xixxixxi
xixixiix xixix xixxix xixiix xixixi xixi xixxixiix xixiix ixxiixix. Xixixix
xix xi ix ix xixi ixixxixi ixxixxixix xixixxix xixixi ixxixxix xixiix
xixxixiix ixxi? "Xixixxix?" Ixixxix xixxixix xixix xixixxi, xix xix xix. Xi
xixxi ixxix. Ix "xixi xixxi," xixix xixiix. Xix xixiixxix xix xixix,
xixiixxixi xixixix ix ix.
```

### Parseltongue

Parseltongue is another letterset just for fun. This one approximates the snake language from Harry Potter.

```
Sasufasa hisuhih hashi afhasas ahahsi tihas hihisesu essiha ushef hitisahih
ihfihih sufa hah sishit sifihhu fuuffih si ihes sehu sas. Ahfahisi tihhahi
eshatih hifi saha, assahasi hahisah fihhehsa fiihsih. Hut ifsiih fah
hissusasi siha as hesah ifihfih uhahsihi sah sisasahus ahhas safa hasi
asahsahu. Saih hifashiha isih itsa fusihis hahaat ashis hehsisi isit sas si
huh hahtuh tasah afhah ih hahfa sihasuse. Sisi sisahis? Hasha hefisatsi
ifef hah hahis sah saha sahahusas hahi hihisa hih hahseseas ihhihasah
"sassias hassitsasi," sasisfes hasi. Sisias hatehhih sausahsah sis hahfisih
hahsah tisih sifisihfihi ashehti hesihha sasisuha fissuf sifasa hisahhah
ahhuhfit sahahe. Ihsis tihasse sashiih.
```
