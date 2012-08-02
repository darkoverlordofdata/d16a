##
#+--------------------------------------------------------------------+
#| benchmark.coffee
#+--------------------------------------------------------------------+
#| Copyright DarkOverlordOfData (c) 2012
#+--------------------------------------------------------------------+
#|                                                                    
#| This file is a part of Katra
#|                                                                    
#| katra is free software; you can copy, modify, and distribute 
#| it under the terms of the GNU General Public License Version 3     
#|                                                                    
#+--------------------------------------------------------------------+
##
#
#	Benchmark class
#
#

##
# This class enables you to mark points and calculate the time difference 
#	between them.
#
class Benchmark

	##
	# Hash of all benchmark markers and time they were added.
	#
	#	@var array
	#
	marker: {}

	##
	# Set a benchmark marker.
	#
	# Multiple calls to this function can be made so that several
	# execution points can be timed
	#
	# @access	public
	# @param	string	name	name of the marker
	# @return	void
	#
	mark: (name) =>

		d = new Date()
		@marker[name] = d.getTime()

	##
	# Calculates the time difference between two marked points.
	#
	# If the first parameter is empty this function instead returns the
	# {elapsed_time} pseudo-variable. This permits the full system
	# execution time to be shown in a template. The output class will
	# swap the real value for this variable.
	#
	# @access	public
	# @param	string	a particular marked point
	# @param	string	a particular marked point
	# @return	mixed
	#
	elapsed_time: (point1, point2) =>

		if point1 is undefined then return ''

		if point2 is undefined 
			d = new Date()
			@marker[name] = d.getTime()

		return @marker[point2] - @marker[point1]

