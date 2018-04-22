import xml.etree.ElementTree
from urllib.parse import urlparse
from collections import defaultdict
import os
from concurrent.futures import ThreadPoolExecutor, as_completed
import urllib.request
import threading


def parse_xml_file(file_dir):
    return xml.etree.ElementTree.parse(file_dir).getroot()


def get_urls(root):
    urls = []
    for child in root[0]:
        if child.tag == "item":
            for grandchild in child:
                if "attachment_url" in grandchild.tag:
                    urls.append(grandchild.text)
    return urls


def get_directories(urls):
    url_dict = defaultdict(set)
    for url in urls:
        year, month = urlparse(url).path.split("/")[1:3]
        url_dict[year].update([month])
    return url_dict


def create_directories(dirs):
    for year, months in dirs.items():
        for month in months:
            directory = "{}/{}".format(year, month)
            if not os.path.exists(directory):
                os.makedirs(directory)


def download_urls_to_dirs(urls):
    result_futures = []
    working_dir = os.getcwd()
    with ThreadPoolExecutor(max_workers=10) as executor:
        for url in urls:
            year, month, filename = urlparse(url).path.split("/")[1:4]
            download_dir = "{}/{}/{}/{}".format(working_dir,
                                                year, month, filename)
            result_futures.append(executor.submit(
                download_url, url, download_dir))
        results = [f.result() for f in as_completed(result_futures)]
        print(results)


def download_url(url, _dir):
    try:
        urllib.request.urlretrieve(url, _dir)
        print("Downloaded url {} to directory {}".format(url, _dir))
        return "Success"
    except:
        return "Fail"


if __name__ == "__main__":
    root = parse_xml_file("/Users/annagarcia/Downloads/brasschicks/brasschicks.wordpress.2018-04-21.001.xml")
    urls = get_urls(root)
    directories = get_directories(urls)
    create_directories(directories)
    download_urls_to_dirs(urls)
