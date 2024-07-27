readMe.md

# Hackaday PHP API of sorts

## Blogs and the Hackaday IO Api
For almost 10 years now, if I haven't posted any "documentation" on twitter,
I have posted about my projects on [hackaday.io](hackaday.io) instead.

There's an [API](dev.hackaday.io) that allows you to request projects, users and most of the data. 
You can access the API via a simple GET request, which will then respond with a JSON document.

```
https://api.hackaday.io/v1/user/:id/?api_key=xxxx
```

I'm almost certain that the hackaday.io team also used the API for the hackaday.io app,
a companion app where you can - in theory - add pictures or notes to your project quickly.
Since I am a power user of sorts, I am not able to see more than 50 of my 115 projects.
There's pagination though, so if there are more projects,
the API can work with a "page" parameter.

So for my projects I had to write a recursive function, that calls itself with a page count parameter.
The API allows 5 requests per second, so that means I can pull up to 250 projects in PHP,
before I have to add delays.

To import the project logs, I made a page that requests logs for a certain project id and then called that page 115 times.
I might rethink this approach, as I have to import images and the detail section still.
For the logs on the projects there's no pagination,
but for the personal pages I've had to integrate recursive pagination again.

The images in the project logs are weird, the image source is not inside a src attribute of the img tag,
but written into a "data-src" attribute. So just displaying the HTML code on my page doesn't bring up the images.
I found a cool solution on stackoverflow, that lets you load HTML in PHP and find DOM elements,
so I was able to get all the images from the logs for a later import.

```
$doc = new DOMDocument();
@$doc->loadHTML($local_post->body);

$tags = $doc->getElementsByTagName('img');

foreach ($tags as $tag) {
    echo $tag->getAttribute('data-src');
    echo '<br>';
}
```

The progress can be found here so far, but be warned - I'm still working on it.

Here are some stats I found interesting, the amount of logs and pages by year. 
From 2018 on I've posted about as much as I did in 2017 alone.
There was definitely a decline of incentives / interactions
and I had gotten much more active on twitter at that point. 

|year|2014|2015|2016|2017|2018|
|---|---|---|---|---|---|
|posts|134|134|102|152|72|

|year|2019|2020|2021|2022|2023|
|---|---|---|---|---|---|
|posts|30|13|23|15|10|


[https://blog.davedarko.com](https://blog.davedarko.com/) \
[https://blog.davedarko.com/projects.php](https://blog.davedarko.com/projects.php)


