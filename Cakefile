fs     = require 'fs'
{exec} = require 'child_process'

appFiles  = [
  # list of files to compile
  'coffee/header'
  'coffee/benchmark'
  'coffee/io'
  'coffee/basic'
  'coffee/runtime'
  'coffee/katra'
]

task 'build', 'Build single application file from source files', ->
  appContents = new Array remaining = appFiles.length
  for file, index in appFiles then do (file, index) ->
    fs.readFile "#{file}.coffee", 'utf8', (err, fileContents) ->
      throw err if err
      appContents[index] = fileContents
      process() if --remaining is 0
  process = ->
    fs.writeFile 'js/katra.coffee', appContents.join('\n\n'), 'utf8', (err) ->
      throw err if err
      exec 'coffee --compile js/katra.coffee', (err, stdout, stderr) ->
        throw err if err
        console.log stdout + stderr
        fs.unlink 'js/katra.coffee', (err) ->
          throw err if err
          console.log 'Done.'