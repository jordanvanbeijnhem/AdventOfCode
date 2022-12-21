package puzzles

import (
	"2022/common"
	"fmt"
	"log"
	"math"
	"strconv"
	"strings"
)

func calculateManhattanDistance(pointA point, pointB point) int {
	return int(math.Abs(float64(pointA.x-pointB.x)) + math.Abs(float64(pointA.y-pointB.y)))
}

func scanLineToPoints(line string) (point, point) {
	line = strings.ReplaceAll(line, ",", "")
	line = strings.ReplaceAll(line, ":", "")
	split := strings.Split(line, " ")
	firstX, _ := strconv.Atoi(strings.TrimPrefix(split[2], "x="))
	firstY, _ := strconv.Atoi(strings.TrimPrefix(split[3], "y="))
	secondX, _ := strconv.Atoi(strings.TrimPrefix(split[8], "x="))
	secondY, _ := strconv.Atoi(strings.TrimPrefix(split[9], "y="))
	return point{x: firstX, y: firstY}, point{x: secondX, y: secondY}
}

func runPuzzle15Part1() {
	lines := common.GetInputLines("day15.txt", false)
	yToCheck := 2000000
	beaconPointsOnY := map[point]bool{}
	scannedPointsOnY := map[point]bool{}
	for _, line := range lines {
		sensorPoint, beaconPoint := scanLineToPoints(line)
		manhattanDistance := calculateManhattanDistance(sensorPoint, beaconPoint)
		if beaconPoint.y == yToCheck {
			beaconPointsOnY[beaconPoint] = true
		}
		yDelta := int(math.Abs(float64(sensorPoint.y - yToCheck)))
		if yDelta <= manhattanDistance {
			for x := -manhattanDistance; x <= manhattanDistance; x++ {
				newPoint := point{x: sensorPoint.x + x, y: yToCheck}
				if calculateManhattanDistance(sensorPoint, newPoint) <= manhattanDistance {
					scannedPointsOnY[newPoint] = true
				}
			}
		}
	}
	fmt.Println("Points that cannot contain a beacon:", len(scannedPointsOnY)-len(beaconPointsOnY))
}

func RunPuzzle15() {
	log.Println("--- STARTING PUZZLE 15 ---")
	runPuzzle15Part1()
	log.Println("--- FINISHED PUZZLE 15 ---")
}
