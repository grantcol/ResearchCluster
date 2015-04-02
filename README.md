# Research Paper Project CS310 (Agile)

## Premise
Similar to project one, this project will focus on aggregating text documents returned from a user search query and generate: 

1. A word cloud of frequent words
2. A list of relevant document titles
3. A link to a pdf version of the document

Unlike last time, however, there are a few upgrades to the system to make it a little more useful and interesting. Namely, I have chosen to implement a term frequency - inverse document frequency (tf-idf) weighting scheme to filter out the stop words (meaningless, common words like 'the', 'a', 'and', etc). The idea is industry standard for NLP, clustering and reccomendation algorithms and so i thought it'd be interesting to play with it. 

##TF-IDF
`W_i = TF_i * N/DF_i`

- W_i => Weight of word i
- TF_i => Term frequency of word i. That is, how many times word i occurs across the document cluster
- N => The number of documents in the document cluster
- DF_i => Document frequency. That is the number of documents word i occurs in

The weight of word i (W_i) can be interpreted as follows. 

1. Highest when the word occurs many times within a small number of documents (thus lending high discriminating power to those documents);
2. Lower when the term occurs fewer times in a document, or occurs in many documents (thus offering a less pronounced relevance signal);
3. Lowest when the term occurs in virtually all documents.

While this weighting system does more than simply weed out stop words and can be used for a much higher purpose than a boring school assignment, it allows us at least to generate a word cloud that represents a group of documents based on relevancy rather than pure frequency. I'll add that frequency alone gives the user little in the way of information other than that the author in question likes a certain word. The probability that the most common words (after pruning with even the most thorough stop word whitelist) are topically relevant still remains fairly low. This weighting scheme improves that relevancy probability significantly. 

##References
* I got the idea for the enhancements and possibly future extensions while reading up on Mahout, a machine learning suite by Apache (for java). If you'd like to look into it I highly recommend [Mahout In Action](http://openresearch.baidu.com/u/cms/www/201210/30144944cqmu.pdf). It's a great book. 
* _Definitely_ on the backburner for now but I came across [this](http://www.jasondavies.com/wordcloud/#%2F%2Fwww.jasondavies.com%2Fwordcloud%2Fabout%2F) while playing around with D3.js (pretty fire library for viz) and might implement in the "make it pretty" time if there is any. 
