import json
import re
import sys

def main():
  version = sys.argv[1]

  files = {
    "functions.php" : {
      "checker": r"'SELLERADISE_VERSION', '\d{1,2}\.\d{1,2}\.\d{1,3}'",
      "replacer": f"'SELLERADISE_VERSION', '{version}'",
    },
    "style.css" : {
      "checker": r"Version: \d{1,2}\.\d{1,2}\.\d{1,3}",
      "replacer": f"Version: {version}",
    },
    "readme.txt" : {
      "checker": r"Stable tag: \d{1,2}\.\d{1,2}\.\d{1,3}",
      "replacer": f"Stable tag: {version}",
    }
  }

  json_files = [
    "composer.json",
    "package.json"
  ]

  for file_path, file_data in files.items():
    with open(file_path, 'r') as f:
      file_content = f.read()

    new_content = re.sub(file_data["checker"], file_data["replacer"], file_content)

    with open(file_path, 'w') as f:
      f.write(new_content)


  for json_file in json_files:
    with open(json_file, 'r') as f:
      content = json.load(f)

    content["version"] = version

    with open(json_file, 'w') as outfile:
      json.dump(content, outfile, indent=2)

    
if __name__ == '__main__':
  main()
